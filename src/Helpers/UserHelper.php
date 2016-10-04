<?php
namespace Lab1353\Monkyz\Helpers;

class UserHelper
{

	public static function gravatar($email='', $size=32)
	{
		if (empty($email) && !empty(user()))
		{
			$email = user()->email;
		}
		$gravatar_link = 'http://www.gravatar.com/avatar/' . md5($email) . '?s='.$size;
		return $gravatar_link;
	}
}