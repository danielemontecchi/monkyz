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

	private static function renderCheckbox($params, $name, $value)
	{
		return  '<i class="fa fa-2x '.($value ? 'fa-check-circle text-success' : 'fa-times-circle text-danger').'" aria-hidden="true"></i>';
	}

	private static function renderDate($params, $name, $value)
	{
		if (!empty($value)) {
			$dt = new Carbon($value);
			$dt->timezone = config('app.timezone');
			return $dt->toDateString();
		} else {
			return '';
		}
	}

	private static function renderDatetime($params, $name, $value)
	{
		if (!empty($value)) {
			$dt = new Carbon($value);
			$dt->timezone = config('app.timezone');
			return $dt->toDateTimeString();
		} else {
			return '';
		}
	}

	private static function renderImage($params, $name, $value)
	{
		return '<img src="'.$value.'" class="img-responsive img-thumbnail" />';
	}

	private static function renderNumber($params, $name, $value)
	{
		$decimal = strlen(substr(strrchr($value, "."), 1));
		$locale = localeconv();
		return number_format($value, $decimal, $locale['decimal_point'], $locale['thousands_sep']);
	}

	private static function renderSelect($params, $name, $value)
	{
    	$model = new DynamicModel;
		$model->setTable($params['source']['table']);
		$field_value = $params['source']['field_value'];
    	$record = $model->where($field_value, $value)->first();
    	if (!empty($record)) {
	    	$field_text = $params['source']['field_text'];

			return  $record->$field_text;
    	} else {
    		return '';
    	}
	}

	private static function renderText($params, $name, $value)
	{
		return  str_limit($value, 30);
	}

	private static function renderUrl($params, $name, $value)
	{
		return '<a href="'.$value.'" title="'.$value.'" target="_blank">'.str_limit($value, 30).'</a>';
	}
}