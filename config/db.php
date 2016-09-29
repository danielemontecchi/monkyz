<?php

/**
 * Parameter 'table': override the dynamic db configuration
 *
 * 'table_name'	=> [	// name of table in db
 *		'title'	=> 'Table',	// title of table
 *		'icon'	=> 'fa fa-table fa-fw',	// the fontawesome icon
 *		'visible'	=> true,	// visibility of table
 *		'fields'	=> [	// list of fields
 *			'field_name'	=> [	// name of field in db
 *				'title'	=> 'Column',	// title of column
 *				'input'	=> 'text',	// input tag type
 *				'in_list'	=> true,	// visibility in list
 *				'in_edit'	=> true,	// visibility in edit and add
 *				'image'	=> [	// image parameters
 *					'path'	=> 'upload/'	// path of images uploaded
 *				]
 *				'relationship'	=> [	// info of relationship
 *					'table'	=> 'table2',	// name of relationship's table
 *					'field_value'	=> 'id',	// name of value field of relationship's table
 *					'field_text'	=> 'name',	// name of text field of relationship's table
 *				],
 *				'attributes'	=> [	// array of extra attributes of field
 *					'class'	=> 'mycss'
 *				]
 *			]
 *		]
 * ]
 */

return [

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

	'tables'	=> [
		'migrations'	=> [
			'visible'	=> false,
		],
		'password_resets'	=> [
			'visible'	=> false,
		],
	],
];