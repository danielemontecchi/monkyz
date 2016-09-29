<?php
namespace Lab1353\Monkyz\Helpers;

use Cache;

class TablesHelper
{
	protected $override_tables;
	protected $input_from_type;
	protected $input_from_name;
	protected $tables;

	public function __construct()
	{
		$this->override_tables = (array)config('lab1353.monkyz.db.tables');
		$this->input_from_type = (array)config('lab1353.monkyz.db.input_from_type');
		$this->input_from_name = (array)config('lab1353.monkyz.db.input_from_name');

		if (Cache::has('monkyz-tables')) {
			$this->tables = Cache::get('monkyz-tables');
		}
	}

	public function getTables()
	{
		if (empty($this->tables)) {
			$override = $this->override_tables;
			$db_tables = collect(\DB::select('SHOW TABLES'))->toArray();
			foreach ($db_tables as $table) {
				$table_name = array_values((array) $table)[0];
				$tables[$table_name] = $this->getTable($table_name);
			}
			$this->tables = $tables;
			Cache::put('monkyz-tables', $tables, 60);
		}

		return $this->tables;
	}

	public function getTable($table_name)
	{
		$table_params = $this->tables[$table_name];
		if (empty($table_params)) {
			$override = $this->override_tables;

			$t_title = ucwords(str_replace('_', ' ', $table_name));
			if (isset($override[$table_name]['title'])) $t_title = $override[$table_name]['title'];
			$t_visible = true;
			if (isset($override[$table_name]['visible'])) $t_visible = $override[$table_name]['visible'];
			$t_icon = 'fa fa-table fa-fw';
			if (isset($override[$table_name]['icon'])) $t_icon = $override[$table_name]['icon'];

			$table_params = [
				'title'	=> $t_title,
				'icon'	=> '<i class="'.$t_icon.'" aria-hidden="true"></i>',
				'visible'	=> $t_visible,
			];
		}

		return $table_params;
	}

	public function getColumns($section)
	{
		$input_from_type = collect($this->input_from_type);
		$input_from_name = collect($this->input_from_name);
		$override_table = (!empty($this->override_tables[$section]['fields'])) ? $this->override_tables[$section]['fields'] : [];

		if (empty($this->tables[$section]['fields'])) {
			$fields_name_hide_in_edit = config('lab1353.monkyz.db.fields_name_hide_in_edit', []);

			$columns = \DB::select('SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`=\''.$section.'\'');
			$fields = [];
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

				// image
				$c_image_path = '';
				if (isset($override['image']['path'])) $c_image_path = $override['image']['path'];

				// relationships
				$source_table = '';
				$source_field_value = '';
				$source_field_text = '';
				if ($c_input=='select') {
					if (isset($override['relationship']['table'])) $source_table = $override['relationship']['table'];
					if (isset($override['relationship']['field_value'])) $source_field_value = $override['relationship']['field_value'];
					if (isset($override['relationship']['field_text'])) $source_field_text = $override['relationship']['field_text'];
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

				$c_in_edit = (!in_array($c_name, $fields_name_hide_in_edit));
				if (isset($override['in_edit'])) $c_in_edit = $override['in_edit'];

				$c_attributes = [ 'class'=>'' ];
				if (isset($override['attributes'])) $c_attributes = array_merge($c_attributes, $override['attributes']);


				$fields[$c_name] = [
					'title'	=> $c_title,
					'type'	=> $c_type,
					'input'	=> $c_input,
					'image'	=> [
						'path'	=> $c_image_path
					],
					'relationship'	=> [
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
			Cache::put('monkyz-tables', $this->tables, 60);
		}

		return $this->tables[$section]['fields'];
	}
}