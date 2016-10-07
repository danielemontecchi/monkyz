<?php

// For parameter 'tables': for correct override read the README.md file

return [

	'input_from_type'	=> [
		'checkbox'	=> ['boolean'],
		'date'	=> ['date'],
		'datetime'	=> ['date','datetime','time','timestamp','year'],
		'hidden'	=> ['key'],
		'number'	=> ['tinyint','smallint','int','mediumint','bigint','decimal','float','double','real','bit','serial'],
		'enum'	=> ['enum'],
		'text'	=> ['char','varchar'],
		'textarea'	=> ['tinytext','mediumtext','text','longtext','tinyblob','mediumblob','blob','longblob'],
	],

	'input_from_name'	=> [
		'checkbox'	=> ['visible','enabled'],
		'color'	=> ['color'],
		'email'	=> ['email'],
		'hidden'	=> ['id','created_at','updated_at','deleted_at'],
		'image'	=> ['image'],
		'number'	=> ['cap','postalcode','quantity','amount'],
		'password'	=> ['password'],
		'tel'	=> ['tel','fax','telephone','phone','cel','mobile','cellular'],
		'url'	=> ['url'],
	],

	'fields_name_hide_in_edit'	=> ['created_at','updated_at','deleted_at'],

	'tables'	=> [
		'migrations'	=> [
			'visible'	=> false,
		],
		'password_resets'	=> [
			'visible'	=> false,
		],
	],
];