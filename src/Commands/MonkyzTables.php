<?php

namespace Lab1353\Monkyz\Commands;

use File;
use Illuminate\Console\Command;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class MonkyzTables extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'monkyz:tables';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate the structure db and save in config file monkyz-tables.php';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$htables = new HTables();

		// Read config file
		$config_file = str_finish(config_path(), '/').'monkyz-tables.php';
		if (!File::exists($config_file)) {
			$path_type = str_replace(str_finish(base_path(), '/'), '', __DIR__);
			$path_type = str_replace('src/Commands', '', $path_type);
			$config_vendor_file = str_finish(base_path($path_type.'/config/'), '/').'monkyz-tables.php';
			if (!File::exists(dirname($config_vendor_file))) File::makeDirectory(dirname($config_vendor_file), 0775, true);
			File::copy($config_vendor_file, $config_file);
			$this->callSilent('config:clear');
			$this->callSilent('config:cache');
		}
		$config = config('monkyz-tables');

		// DB struct
		$this->line('Reading DB structure');
		$tables = $htables->getDb();

		// Config string
		$this->line('Updating config file');
		$str = "<?php\n\n";
		$str .= "/**\n * For parameter 'tables': for correct override read the README.md file\n */\n\n";
		$str .= "return [\n\n";
		foreach ($config as $k=>$v) {
			if ($k=='tables') {
				$str .= "	'tables'	=> ".$this->arrayoToString($tables, 2);
			} else {
				$str .= "	'$k'	=> ".$this->arrayoToString($v, 2)."\n";
			}
		}
		$str .= "\n];";

		// Write config file
		$this->line('Writing config file');
		if (File::put($config_file, $str)) {
			$this->callSilent('config:clear');
			$this->callSilent('config:cache');
			$htables->clearCache();

			$this->info('File '.$config_file.' updated correctly!');
		} else {
			$this->error('It is an error in the file write: '.$config_file);
		}
	}

	private function arrayoToString($array, $level=1)
	{
		$str = '';
		if (is_array($array)) {
			$str = "[";
			$i = 1;
			$c = count($array);
			foreach ($array as $k=>$v) {
				if (is_array($v)) {
					if ($i==1) $str .= "\n".str_repeat('	', $level);
					$str .= "'$k'	=> ".$this->arrayoToString($v, $level+1)."\n";
					if ($i==$c) {
						$str .= str_repeat('	', $level-1);
					} else {
						$str .= str_repeat('	', $level);
					}
				} else {
					if (is_int($k)) {
						$str .= " '$v'";
						$str .= ($i !== $c) ? ',' : ' ';
					} else {
						if ($i===1) $str .= "\n".str_repeat('	', $level);
						$str .= "'$k'	=> ";
						if (in_array($k, ['in_list','in_edit','overwrite','visible'])) {
							$str .= ((bool)$v) ? 'true' : 'false';
						} else {
							$str .= "'$v'";
						}
						if ($i==$c) {
							$str .= ",\n".str_repeat('	', $level-1);
						} else {
							$str .= ",\n".str_repeat('	', $level);
						}
					}
				}
				$i++;
			}
			$str .= "],";
		} else {
			$str .= "'$array', \n".str_repeat('	', $level);
		}

		return $str;
	}
}
