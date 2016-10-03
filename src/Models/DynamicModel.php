<?php

namespace Lab1353\Monkyz\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class DynamicModel extends Model
{
	protected static $_table;

	public $timestamps = false;
	protected $dates = [];
	//TODO: manage softDeleting: https://laravel.com/docs/5.2/eloquent#soft-deleting

	public function setTable($table)
	{
		static::$_table = $table;

		$this->setParameters($table);
	}
	public function getTable()
	{
		return static::$_table;
	}

	public function setParameters($table)
	{
		$htables = new HTables();
		$fields = $htables->getColumns($table);

		$f_created = false;
		$f_updated = false;
		$f_dates = [];

		foreach ($fields as $field=>$params) {
			if ($field=='created_at') $f_created = true;
			if ($field=='updated_at') $f_updated = true;
			if (in_array($params['input'], ['date','datetime'])) $f_dates[] = $field;
		}

		$this->dates = $f_dates;
		$this->timestamps = ($f_created && $f_updated);
	}
}
