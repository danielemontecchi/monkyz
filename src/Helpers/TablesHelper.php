<?php
namespace Lab1353\Monkyz\Helpers;

use Cache;

class TablesHelper
{
	protected $override_tables;
	protected $input_from_type;
	protected $input_from_name;

	protected $tables;

	protected $cache_key = 'monkyz-tables';
	protected $cache_minutes = 60;

	public function __construct()
	{
		$this->override_tables = (array)config('lab1353.monkyz.db.tables', []);
		$this->input_from_type = (array)config('lab1353.monkyz.db.input_from_type', []);
		$this->input_from_name = (array)config('lab1353.monkyz.db.input_from_name', []);

		if (Cache::has($this->cache_key)) {
			$this->tables = Cache::get($this->cache_key);
		}
	}

	public function clearCache()
	{
		Cache::forget($this->cache_key);
		$this->tables = [];
	}

	public function getDb()
	{
		$this->clearCache();

		$tables = $this->getTables();
		foreach ($tables as $table=>$params) {
			$this->getColumns($table);
		}

		return $this->tables;
	}

	public function getTables()
	{
		if (empty($this->tables)) {
			$tables = [];
			$override = $this->override_tables;
			$db_tables = collect(\DB::select('SHOW TABLES'))->toArray();
			foreach ($db_tables as $table) {
				$table_name = array_values((array) $table)[0];
				$params = $this->getTable($table_name);
				$tables[$table_name] = $params;
			}
			$this->tables = $tables;
			Cache::put($this->cache_key, $tables, $this->cache_minutes);
		}

		return $this->tables;
	}

	public function getTable($table_name)
	{
		$table_params = (!empty($this->tables[$table_name])) ? $this->tables[$table_name] : [];
		if (empty($table_params)) {
			$override = (!empty($this->override_tables[$table_name])) ? $this->override_tables[$table_name] : [];

			$t_title = ucwords(str_replace('_', ' ', $table_name));
			if (isset($override['title'])) $t_title = $override['title'];
			$t_visible = true;
			if (isset($override['visible'])) $t_visible = $override['visible'];
			$t_icon = 'fa fa-table';
			if (isset($override['icon'])) $t_icon = $override['icon'];

			$table_params = [
				'title'	=> $t_title,
				'icon'	=> $t_icon,
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

				$override = $override_table[$c_name];

				$c_title = ucwords(str_replace('_', ' ', $c_name));
				if (isset($override['title'])) $c_title = $override['title'];

				$c_type = $column->DATA_TYPE;
				if ($column->COLUMN_KEY=='PRI') $c_type = 'key';

				$c_input = '';
				if (empty($c_input)) {
					if (ends_with($c_name, '_id')) {
						$c_input = 'relation';
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
				if (!in_array($c_input, ['block', 'checkbox', 'color', 'date', 'datetime', 'editor', 'enum',
										'file', 'hidden', 'image', 'number', 'relation', 'tel', 'text', 'textarea', 'url'])) {
					$c_input = '';
				}
				if (empty($c_input)) $c_input = 'text';
				if (isset($override['input'])) $c_input = $override['input'];

				$c_default = (!empty($column->COLUMN_DEFAULT)) ? $column->COLUMN_DEFAULT : '';

				$c_in_list = (!in_array($c_type, ['text', 'key']) && !in_array($c_name, $fields_name_hide_in_edit));
				if (isset($override['in_list'])) $c_in_list = $override['in_list'];

				$c_in_edit = (!in_array($c_name, $fields_name_hide_in_edit));
				if (isset($override['in_edit'])) $c_in_edit = $override['in_edit'];

				// file
				$c_file = [
					'path'	=> 'uploads/',
					'overwrite'	=> true,
				];
				if (isset($override['file']['path'])) $c_file['path'] = $override['file']['path'];
				if (isset($override['file']['overwrite'])) $c_image['overwrite'] = (bool)$override['file']['overwrite'];

				// enum
				$c_enum = [];
				if ($c_input=='enum') {
					$enum_str = (string)$column->COLUMN_TYPE;
					$enum_str = str_replace(['enum','(','\'',')'], '', $enum_str);
					$enum = explode(',', $enum_str);
					foreach ($enum as $k) {
						$v = str_replace('-', ' ', $k);
						$v = ucfirst($v);
						$c_enum[$k] = $v;
					}
				}
				if (!empty($override['enum'])) $c_enum = $override['enum'];

				// image
				$c_image = [
					'path'	=> 'uploads/',
					'overwrite'	=> true,
					'resize'	=> false,
				];
				if (isset($override['image']['path'])) $c_image['path'] = $override['image']['path'];
				if (isset($override['image']['overwrite'])) $c_image['overwrite'] = (bool)$override['image']['overwrite'];
				if (isset($override['image']['resize'])) $c_image['resize'] = (bool)$override['image']['resize'];

				// relationships
				$c_relation = [
					'table'	=> '',
					'field_value'	=> '',
					'field_text'	=> '',
				];
				if ($c_input=='relation') {
					if (isset($override['relation']['table'])) $c_relation['table'] = $override['relation']['table'];
					if (isset($override['relation']['field_value'])) $c_relation['field_value'] = $override['relation']['field_value'];
					if (isset($override['relation']['field_text'])) $c_relation['field_text'] = $override['relation']['field_text'];
					if (empty($c_relation['table'])) {
						$c_title = str_replace(' Id', '', $c_title);
						$st = str_plural(str_replace('_id', '', $c_name));
						if (!empty($this->tables[$st])) {
							$c_relation['table'] = $st;

							if (empty($c_relation['field_text']) || empty($c_relation['field_value'])) {
								$this->getColumns($st);
								$sfs = $this->tables[$st]['fields'];

								if (!empty($sfs)) {
									foreach ($sfs as $sf=>$sfp) {
										if (empty($c_relation['field_text']) && $sfp['input']=='text') {
											$c_relation['field_text'] = $sf;
										}
										if (empty($c_relation['field_value']) && $sfp['type']=='key') {
											$c_relation['field_value'] = $sf;
										}
									}
								}
							}
						}
					}
				}

				// attributes
				$c_attributes = [];

				if (!in_array($c_input, ['textarea', 'editor'])) {
					//TODO: controllare per i float
					$length = (int)($c_type=='number') ? $column->NUMERIC_PRECISION : $column->CHARACTER_MAXIMUM_LENGTH;
					if ($length>0) $override['attributes']['maxlength'] = $length;
				}

				if ($column->IS_NULLABLE=='NO' && empty($column->COLUMN_DEFAULT) && $c_type!='key') $c_attributes['required'] = 'required';

				if (isset($override['attributes'])) {
					foreach ($override['attributes'] as $k=>$v) {
						$c_attributes[$k] = $v;
					}
				}


				$fields[$c_name] = [
					'title'	=> $c_title,
					'type'	=> $c_type,
					'input'	=> $c_input,
					'default'	=> $c_default,
					'in_list'	=> $c_in_list,
					'in_edit'	=> $c_in_edit,
					'enum'	=> $c_enum,
					'file'	=> $c_file,
					'image'	=> $c_image,
					'relation'	=> $c_relation,
					'attributes'	=> $c_attributes
				];

				// clean array
				if ($c_input!='enum') unset($fields[$c_name]['enum']);
				if ($c_input!='relation') unset($fields[$c_name]['relation']);
				if ($c_input!='image') unset($fields[$c_name]['image']);
				if ($c_input!='file') unset($fields[$c_name]['file']);
			}

			$this->tables[$section]['fields'] = $fields;
			Cache::put($this->cache_key, $this->tables, $this->cache_minutes);
		}

		return $this->tables[$section]['fields'];
	}
}