<?php
namespace Lab1353\Monkyz\Helpers;

use Illuminate\Support\Facades\Cache;

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
		$this->override_tables = (array)config('monkyz-tables.tables', []);
		$this->input_from_type = (array)config('monkyz-tables.input_from_type', []);
		$this->input_from_name = (array)config('monkyz-tables.input_from_name', []);
		$this->cache_minutes = (int)config('monkyz.cache_minutes', 60);

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
			$db_connection = config('database.default');
			$db_name = config('database.connections.'.$db_connection.'.database');
			if (!empty($db_name)) {
				$query = 'SELECT table_name FROM information_schema.tables WHERE table_type = \'BASE TABLE\' AND table_schema=\''.$db_name.'\' ORDER BY table_name ASC';
			} else {
				$query = 'SHOW TABLES';
			}
			$db_tables = collect(\DB::select($query))->toArray();
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

	public function findKeyFieldName($table)
	{
		$key_field = 'id';
		$columns = $this->getColumns($table);
		foreach ($columns as $column => $params) {
			if ($params['type']=='key') {
				$key_field = $column;
				break;
			}
		}

		return $key_field;
	}

	public function getColumns($section)
	{
		$input_from_type = collect($this->input_from_type);
		$input_from_name = collect($this->input_from_name);
		$override_table = (!empty($this->override_tables[$section]['fields'])) ? $this->override_tables[$section]['fields'] : [];

		if (empty($this->tables[$section]['fields'])) {
			$fields_name_hide_in_edit = config('monkyz-tables.fields_name_hide_in_edit', []);

			$db_name = Config::get('database.connections.'.Config::get('database.default').'.database');
			$columns = \DB::select('SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`=\''.$section.'\' AND `TABLE_SCHEMA`=\''.$db_name.'\'');
			$fields = [];
			foreach ($columns as $column) {
				$c_name = $column->COLUMN_NAME;

				$override = [];
				if (!empty($override_table[$c_name])) $override = $override_table[$c_name];

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
				if (empty($c_input)) $c_input = 'text';
				if (isset($override['input'])) $c_input = $override['input'];

				$c_default = (!empty($column->COLUMN_DEFAULT)) ? $column->COLUMN_DEFAULT : '';

				$c_in_list = (!in_array($c_type, ['text', 'key']) && !in_array($c_name, $fields_name_hide_in_edit));
				if (isset($override['in_list'])) $c_in_list = $override['in_list'];

				$c_in_edit = (!in_array($c_name, $fields_name_hide_in_edit));
				if (isset($override['in_edit'])) $c_in_edit = $override['in_edit'];

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

				// file/image
				$c_file = [
					'disk'	=> 'local',
					'path'	=> 'uploads/',
					'overwrite'	=> true,
					'resize'	=> false,
					'resize_height_px'	=> 1000,
					'resize_width_px'	=> 1000,
				];
				if (isset($override['file']['disk'])) $c_file['disk'] = $override['file']['disk'];
				if (isset($override['file']['path'])) $c_file['path'] = $override['file']['path'];
				if (isset($override['file']['overwrite'])) $c_file['overwrite'] = (bool)$override['file']['overwrite'];
				if (isset($override['file']['resize'])) $c_file['resize'] = (bool)$override['file']['resize'];
				if (isset($override['file']['resize_height_px'])) $c_file['resize_height_px'] = (int)$override['file']['resize_height_px'];
				if (isset($override['file']['resize_width_px'])) $c_file['resize_width_px'] = (int)$override['file']['resize_width_px'];

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

				if ($column->IS_NULLABLE=='NO' && is_null($column->COLUMN_DEFAULT) && $c_type!='key') $c_attributes['required'] = 'required';
				if (empty($override['attributes']['required'])) unset($c_attributes['required']);

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
					'relation'	=> $c_relation,
					'attributes'	=> $c_attributes
				];

				// clean array
				if ($c_input!='enum') unset($fields[$c_name]['enum']);
				if ($c_input!='relation') unset($fields[$c_name]['relation']);
				if (!in_array($c_input, ['file', 'image'])) unset($fields[$c_name]['file']);
			}

			$this->tables[$section]['fields'] = $fields;
			Cache::put($this->cache_key, $this->tables, $this->cache_minutes);
		}

		return $this->tables[$section]['fields'];
	}
}