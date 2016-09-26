<?php
namespace Lab1353\Monkyz\Helpers;

use Carbon\Carbon;
use Lab1353\Monkyz\Models\DynamicModel;

class FieldsHelper
{
	public static function renderInList($params, $value)
	{
		$input = $params['input'];

		$echo = '<td>';
		switch ($input) {
		    case 'checkbox':
		    	$echo = '<td align="center">';
		    	$echo .= self::renderCheckbox($params, '', $value);
		        break;
		    case 'date':
		    	$echo .= self::renderDate($params, '', $value);
		        break;
		    case 'datetime':
		    	$echo .= self::renderDatetime($params, '', $value);
		        break;
		    case 'image':
		    	$echo .= self::renderImage($params, '', $value);
		        break;
		    case 'number':
		    	$echo = '<td align="right">';
		    	$echo .= self::renderNumber($params, '', $value);
		        break;
		    case 'select':
		    	$echo .= self::renderSelect($params, '', $value);
		        break;
		    case 'url':
		    	$echo .= self::renderUrl($params, '', $value);
		        break;
		    default:
		    	$echo .= self::renderText($params, '', $value);
		}
		$echo .= '</td>';

		return $echo;
	}

	private static function renderCheckbox($params, $name, $value, $inList = true)
	{
		if ($inList) {
			return  '<i class="fa fa-2x '.($value ? 'fa-check-circle text-success' : 'fa-times-circle text-danger').'" aria-hidden="true"></i>';
		} else {
			return '';
		}
	}

	private static function renderDate($params, $name, $value, $inList = true)
	{
		if ($inList) {
			if (!empty($value)) {
				$dt = new Carbon($value);
				$dt->timezone = config('app.timezone');
				return $dt->toDateString();
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	private static function renderDatetime($params, $name, $value, $inList = true)
	{
		if ($inList) {
			if (!empty($value)) {
				$dt = new Carbon($value);
				$dt->timezone = config('app.timezone');
				return $dt->toDateTimeString();
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	private static function renderImage($params, $name, $value, $inList = true)
	{
		if ($inList) {
			return '<img src="'.$value.'" class="img-responsive img-thumbnail" />';
		} else {
			return '';
		}
	}

	private static function renderNumber($params, $name, $value, $inList = true)
	{
		if ($inList) {
			$decimal = strlen(substr(strrchr($value, "."), 1));
			$locale = localeconv();
			return number_format($value, $decimal, $locale['decimal_point'], $locale['thousands_sep']);
		} else {
			return '';
		}
	}

	private static function renderSelect($params, $name, $value, $inList = true)
	{
		if ($inList) {
	    	$model = new DynamicModel;
			$model->setTable($params['source_table']);
	    	$records = $model->find($value);
	    	if (!empty($records)) {
	    		$record = $records->first();
		    	$field = $params['source_field'];

				return  $record->$field;
	    	} else {
	    		return '';
	    	}
		} else {
			return '';
		}
	}

	private static function renderText($params, $name, $value, $inList = true)
	{
		if ($inList) {
			return  str_limit($value, 30);
		} else {
			return '';
		}
	}

	private static function renderUrl($params, $name, $value, $inList = true)
	{
		if ($inList) {
			return '<a href="'.$value.'" title="'.$value.'" target="_blank">'.str_limit($value, 30).'</a>';
		} else {
			return '';
		}
	}
}