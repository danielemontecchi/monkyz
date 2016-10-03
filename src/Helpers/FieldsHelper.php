<?php
namespace Lab1353\Monkyz\Helpers;

use Cache;
use Storage;
use Carbon\Carbon;
use Lab1353\Monkyz\Models\DynamicModel;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;
use Lab1353\Monkyz\Helpers\FileHelper as HFile;

class FieldsHelper
{

	public static function getEnum($table, $field_name)
	{
		if (empty($table) || empty($field_name)) {
			return '';
		} else {
			$htables = new HTables();
			$fields = $htables->getColumns($table);
			$enum = (array)$fields[$field_name]['enum'];

			return $enum;
		}
	}

	public static function renderInList($params, $value)
	{
		$input = $params['input'];

		$echo = '<td>';
		switch ($input) {
		    case 'checkbox':
		    	$echo = '<td align="center">';
		    	$echo .= self::renderCheckbox($params, $value);
		        break;
		    case 'color':
		    	$echo = '<td align="center">';
		    	$echo .= self::renderColor($params, $value);
		        break;
		    case 'date':
		    	$echo .= self::renderDate($params, $value);
		        break;
		    case 'datetime':
		    	$echo .= self::renderDatetime($params, $value);
		        break;
		    case 'enum':
		    	$echo .= self::renderEnum($params, $value);
		        break;
		    case 'file':
		    	$echo .= self::renderFile($params, $value);
		        break;
		    case 'image':
		    	$echo .= self::renderImage($params, $value);
		        break;
		    case 'number':
		    	$echo = '<td align="right">';
		    	$echo .= self::renderNumber($params, $value);
		        break;
		    case 'relation':
		    	$echo .= self::renderRelation($params, $value);
		        break;
		    case 'tel':
		    	$echo .= self::renderTel($params, $value);
		        break;
		    case 'url':
		    	$echo .= self::renderUrl($params, $value);
		        break;
		    default:	// text, block, hidden
		    	$echo .= self::renderText($params, $value);
		}
		$echo .= '</td>';

		return $echo;
	}

	private static function renderCheckbox($params, $value)
	{
		return  '<i class="fa fa-2x '.($value ? 'fa-check-circle text-success' : 'fa-times-circle text-danger').'" aria-hidden="true"></i>';
	}

	private static function renderColor($params, $value)
	{
		return  '<div style="background: '.$value.'; height: 30px; width: 50px;"></div>';
	}

	private static function renderDate($params, $value)
	{
		if (!empty($value)) {
			$dt = new Carbon($value);
			$dt->timezone = config('app.timezone');
			return $dt->toDateString();
		} else {
			return '';
		}
	}

	private static function renderDatetime($params, $value)
	{
		if (!empty($value)) {
			$dt = new Carbon($value);
			$dt->timezone = config('app.timezone');
			return $dt->toDateTimeString();
		} else {
			return '';
		}
	}

	private static function renderEnum($params, $value)
	{
		$enum = $params['enum'];

		return  $enum[$value];
	}

	private static function renderFile($params, $value)
	{
		$hfile = new HFile();

		$icon = $hfile->getUrlFileTypeIcon($value);
		$img = '<img src="'.$icon.'" class="img-thumbnail" />';

		return $img;
	}

	private static function renderImage($params, $value)
	{
		$hfile = new HFile();
		$img = '';
		$url = $hfile->getUrlFromParams($params, $value);
		if (!empty($url)) $img = '<img src="'.$url.'" data-src="'.$value.'" class="img-responsive img-thumbnail" />';

		return $img;
	}

	private static function renderNumber($params, $value)
	{
		$decimal = strlen(substr(strrchr($value, "."), 1));
		$locale = localeconv();
		return number_format($value, $decimal, $locale['decimal_point'], $locale['thousands_sep']);
	}

	private static function renderRelation($params, $value)
	{
		$record = null;
		$source_table = $params['relation']['table'];
		$field_value = $params['relation']['field_value'];
	    $field_text = $params['relation']['field_text'];
		if (!empty($source_table) && !empty($field_value)) {
	    	$model = new DynamicModel;
			$model->setTable($source_table);
			$record = $model->where($field_value, $value)->first();
		}

    	if (!empty($record)) {
			return  $record->$field_text;
    	} else {
    		return '';
    	}
	}

	private static function renderTel($params, $value)
	{
		return  '<a href="tel:'.$value.'">'.$value.'</a>';
	}

	private static function renderText($params, $value)
	{
		return  str_limit($value, 30);
	}

	private static function renderUrl($params, $value)
	{
		return '<a href="'.$value.'" title="'.$value.'" target="_blank">'.str_limit($value, 30).'</a>';
	}
}