<?php

return [
	'prefix'	=> 'monkyz',	// prefix of url for access at Monkyz

	'input_from_type'	=> [
		'checkbox'	=> ['boolean'],
		'date'	=> ['date'],
		'datetime'	=> ['date','datetime','time','timestamp','year'],
		'hidden'	=> ['key'],
		'numeric'	=> ['tinyint','smallint','int','mediumint','bigint','decimal','float','double','real','bit','serial'],
		'select'	=> ['enum'],
		'text'	=> ['char','varchar'],
		'textarea'	=> ['tinytext','mediumtext','text','longtext','tinyblob','mediumblob','blob','longblob'],
	],

	'input_from_name'	=> [
		'checkbox'	=> ['visible','enabled'],
		'color'	=> ['color'],
		'email'	=> ['email'],
		'hidden'	=> ['id','created_at','updated_at','deleted_at'],
		'image'	=> ['image'],
		'password'	=> ['password'],
		'tel'	=> ['tel','fax','telephone'],
		'url'	=> ['url'],
	],

	'fields_name_hide_in_edit'	=> ['created_at','updated_at','deleted_at'],
];