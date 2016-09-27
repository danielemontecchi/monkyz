<?php

namespace Lab1353\Monkyz\Models;

use Illuminate\Database\Eloquent\Model;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class DynamicModel extends Model
{
	protected static $_table;
	public $timestamps = false;
	//TODO: manage softDeleting: https://laravel.com/docs/5.2/eloquent#soft-deleting

	public function setTable($table)
	{
		static::$_table = $table;

		$this->setTimestamps($table);
	}

	public function getTable()
	{
		return static::$_table;
	}

	public function setTimestamps($table)
	{
		$htables = new HTables();
		$fields = $htables->getColumns($table);
		$f_created = false;
		$f_updated = false;
		foreach ($fields as $field=>$params) {
			if ($field=='created_at') $f_created = true;
			if ($field=='updated_at') $f_updated = true;
		}

		$this->timestamps = ($f_created && $f_updated);
	}
}
