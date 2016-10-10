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
		'users'	=> [
			'title'	=> 'Users',
			'icon'	=> 'fa fa-users',
			'visible'	=> true,
			'fields'	=> [
				'id'	=> [
					'title'	=> 'Id',
					'type'	=> 'key',
					'input'	=> 'hidden',
					'default'	=> '',
					'in_list'	=> false,
					'in_edit'	=> true,
					'attributes'	=> [],
				],
				'name'	=> [
					'title'	=> 'Name',
					'type'	=> 'varchar',
					'input'	=> 'text',
					'default'	=> '',
					'in_list'	=> true,
					'in_edit'	=> true,
					'attributes'	=> [
						'required'	=> 'required',
						'maxlength'	=> '255',
					],
				],
				'email'	=> [
					'title'	=> 'Email',
					'type'	=> 'varchar',
					'input'	=> 'email',
					'default'	=> '',
					'in_list'	=> true,
					'in_edit'	=> true,
					'attributes'	=> [
						'required'	=> 'required',
						'maxlength'	=> '255',
					],
				],
				'password'	=> [
					'title'	=> 'Password',
					'type'	=> 'varchar',
					'input'	=> 'password',
					'default'	=> '',
					'in_list'	=> false,
					'in_edit'	=> true,
					'attributes'	=> [
						'value'	=> '',
						'maxlength'	=> '255',
					],
				],
				'remember_token'	=> [
					'title'	=> 'Remember Token',
					'type'	=> 'varchar',
					'input'	=> 'text',
					'default'	=> '',
					'in_list'	=> false,
					'in_edit'	=> false,
					'attributes'	=> [
						'maxlength'	=> '100',
					],
				],
				'created_at'	=> [
					'title'	=> 'Created At',
					'type'	=> 'timestamp',
					'input'	=> 'hidden',
					'default'	=> '',
					'in_list'	=> false,
					'in_edit'	=> false,
					'attributes'	=> [],
				],
				'updated_at'	=> [
					'title'	=> 'Updated At',
					'type'	=> 'timestamp',
					'input'	=> 'hidden',
					'default'	=> '',
					'in_list'	=> false,
					'in_edit'	=> false,
					'attributes'	=> [],
				],
			],
		],
	],
];