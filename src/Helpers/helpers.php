<?php



/*******************
*****  STRING  *****
********************/

if (!function_exists('str_start')) {
	/**
	 * Check that the string begins with a given character. If you can not find the character, it adds.
	 */
	function str_start($string, $char) {
		$ss = substr($string, 0, strlen($char));

		if ($ss != $char)
		{
			$string = $char.$string;
		}

		return $string;
	}
}