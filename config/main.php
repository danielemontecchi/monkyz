<?php

return [
	'prefix'	=> 'monkyz',	// prefix of url for access at Monkyz

	'input_from_type'	=> [
		'date'	=> ['date'],
		'datetime'	=> ['timestamp','datetime'],
		'hidden'	=> ['key'],
		'numeric'	=> ['int'],
		'text'	=> ['varchar'],
		'textarea'	=> ['text'],
	],

	'input_from_name'	=> [
		'checkbox'	=> ['visible','enabled'],
		'email'	=> ['email'],
		'hidden'	=> ['id','created_at','updated_at','deleted_at'],
		'image'	=> ['image'],
		'password'	=> ['password'],
		'tel'	=> ['tel','fax','telephone'],
		'url'	=> ['url'],
	],

	/**
	 * Override the dynamic db configuration
	 *
	 * 'table_name'	=> [	// name of table in db
	 *		'title'	=> 'Table',	// title of table
	 *		'icon'	=> 'fa fa-table fa-fw',	// the fontawesome icon
	 *		'visible'	=> true,	// visibility of table
	 *		'fields'	=> [	// list of fields
	 *			'field_name'	=> [	// name of field in db
	 *				'title'	=> 'Column',	// title of column
	 *				'input'	=> 'text',	// input tag type
	 *				'source_table'	=> 'table2',	// name of relationship's table
	 *				'source_field'	=> 'name',	// name of string of relationship's table
	 *				'in_list'	=> true,	// visibility in list
	 *				'in_edit'	=> true,	// visibility in edit and add
	 *			]
	 *		]
	 * ]
	 */
	'override_db_configuration'	=> [
		'migrations'	=> [
			'visible'	=> false,
		],
		'password_resets'	=> [
			'visible'	=> false,
		],
	],
];