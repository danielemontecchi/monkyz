<?php

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
 *				'in_list'	=> true,	// visibility in list
 *				'in_edit'	=> true,	// visibility in edit and add
 *				'source'	=> [	// info of relationship
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
	'tables'	=> [
		'migrations'	=> [
			'visible'	=> false,
		],
		'password_resets'	=> [
			'visible'	=> false,
		],
	],
];