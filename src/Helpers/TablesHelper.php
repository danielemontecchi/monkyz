<?php
namespace Lab1353\Monkyz\Helpers;

class TablesHelper
{
	protected $override_db_configuration;
	protected $input_from_type;
	protected $input_from_name;
	protected $tables;

	public function __construct()
	{
		$this->override_db_configuration = (array)config('lab1353.monkyz.main.override_db_configuration');
		$this->input_from_type = (array)config('lab1353.monkyz.main.input_from_type');
		$this->input_from_name = (array)config('lab1353.monkyz.main.input_from_name');
	}

	public function getTables()
	{
		$override = $this->override_db_configuration;
		$db_tables = collect(\DB::select('SHOW TABLES'))->toArray();
		foreach ($db_tables as $table) {
			$table_name = array_values((array) $table)[0];
			$tables[$table_name] = $this->getTable($table_name);
		}
		$this->tables = $tables;

		return $tables;
	}

	public function getTable($table_name)
	{
		$override = $this->override_db_configuration;

		$t_title = ucwords(str_replace('_', ' ', $table_name));
		if (isset($override[$table_name]['title'])) $t_title = $override[$table_name]['title'];
		$t_visible = true;
		if (isset($override[$table_name]['visible'])) $t_visible = $override[$table_name]['visible'];
		$t_icon = 'fa fa-table fa-fw';
		if (isset($override[$table_name]['icon'])) $t_icon = $override[$table_name]['icon'];

		return [
			'title'	=> $t_title,
			'icon'	=> '<i class="'.$t_icon.'" aria-hidden="true"></i>',
			'visible'	=> $t_visible,
		];
	}

	public function getColumns($section)
	{
		$input_from_type = collect($this->input_from_type);
		$input_from_name = collect($this->input_from_name);
		$override_table = (!empty($this->override_db_configuration[$section]['fields'])) ? $this->override_db_configuration[$section]['fields'] : [];

		if (empty($this->tables[$section]['fields'])) {
			$columns = \DB::select('SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`=\''.$section.'\'');
			foreach ($columns as $column) {
				$c_name = $column->COLUMN_NAME;
				$override = (!empty($override_table[$c_name])) ? $override_table[$c_name] : [];

				$c_title = ucwords(str_replace('_', ' ', $c_name));
				if (isset($override['title'])) $c_title = $override['title'];

				$c_type = $column->DATA_TYPE;
				if ($column->COLUMN_KEY=='PRI') $c_type = 'key';

				$c_input = '';
				if (empty($c_input)) {
					if (ends_with($c_name, '_id')) {
						$c_input = 'select';
					}
				}
				if (empty($c_input)) {
					$c_input = $input_from_name->search(function ($value, $key) use ($c_name) {
						return in_array($c_name, $value);
					});
				}
				if (empty($c_input)) {
					$c_input = $input_from_type->search(function ($value, $key) use ($c_type) {
						return in_array($c_type, $value);
					});
				}
				if (empty($c_input)) $c_input = 'text';
				if (isset($override['input'])) $c_input = $override['input'];

				// relationships
				$source_table = '';
				$source_field_value = '';
				$source_field_text = '';
				if ($c_input=='select') {
					if (isset($override['source']['table'])) $source_table = $override['source']['table'];
					if (isset($override['source']['field_value'])) $source_field_value = $override['source']['field_value'];
					if (isset($override['source']['field_text'])) $source_field_text = $override['source']['field_text'];
					if (empty($source_table)) {
						$c_title = str_replace(' Id', '', $c_title);
						$st = str_plural(str_replace('_id', '', $c_name));
						if (!empty($this->tables[$st])) {
							$source_table = $st;

							if (empty($source_field_text) || empty($source_field_value)) {
								$this->getColumns($st);
								$sfs = $this->tables[$st]['fields'];

								if (!empty($sfs)) {
									foreach ($sfs as $sf=>$sfp) {
										if (empty($source_field_text) && $sfp['input']=='text') {
											$source_field_text = $sf;
										}
										if (empty($source_field_value) && $sfp['type']=='key') {
											$source_field_value = $sf;
										}
									}
								}
							}
						}
					}
				}

				$c_length = (int)($c_type=='int') ? $column->NUMERIC_PRECISION : $column->CHARACTER_MAXIMUM_LENGTH;

				$c_required = ($column->IS_NULLABLE=='NO');

				$c_default = $column->COLUMN_DEFAULT;
				if ($c_required && is_null($c_default)) $c_default = ($c_input=='numeric') ? 0 : '';

				$c_in_list = (!in_array($c_type, ['text']));
				if (isset($override['in_list'])) $c_in_list = $override['in_list'];

				$c_in_edit = (!in_array($c_name, config('lab1353.monkyz.main.fields_name_hide_in_edit')));
				if (isset($override['in_edit'])) $c_in_edit = $override['in_edit'];

				$c_attributes = [ 'class'=>'' ];
				if (isset($override['attributes'])) $c_attributes = array_merge($c_attributes, $override['attributes']);


				$fields[$c_name] = [
					'title'	=> $c_title,
					'type'	=> $c_type,
					'input'	=> $c_input,
					'source'	=> [
						'table'	=> $source_table,
						'field_value'	=> $source_field_value,
						'field_text'	=> $source_field_text,
					],
					'length'	=> $c_length,
					'default'	=> $c_default,
					'required'	=> $c_required,
					'in_list'	=> $c_in_list,
					'in_edit'	=> $c_in_edit,
					'attributes'	=> $c_attributes
				];
			}

			$this->tables[$section]['fields'] = $fields;
		}

		return $this->tables[$section]['fields'];
	}
}