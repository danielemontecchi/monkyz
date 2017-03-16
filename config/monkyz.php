<?php

return [
	'prefix'	=> 'monkyz',	// prefix of url for access at Monkyz
	'use_https'	=> false,	// force chema https
	'use_auth'	=> true,	// laravel authentication

	'cache_minutes'	=> 60,	// minutes of duration of cache

	'path_public_temp'	=> 'monkyz_temp/',	// folder name, in `public` path, for temporary files

	'vendors'	=> [	// version of assets
		'bootstrap'	=> '3.3.7',	// https://www.bootstrapcdn.com/
		'bootstrap3wysiwyg'	=> '0.3.3', // https://cdnjs.com/libraries/bootstrap3-wysiwyg
		'datatables'	=> '1.10.13',	// https://cdn.datatables.net/
		'fontawesome'	=> '4.7.0',	// https://www.bootstrapcdn.com/fontawesome/
		'jquery'	=> '1.12.4',	// https://code.jquery.com/
		'html5shiv'	=> '3.7.3',	// http://www.jsdelivr.com/projects/html5shiv
		'pace'	=> '1.0.2',	// https://cdnjs.com/libraries/pace
		'respond'	=> '1.4.2',	// http://www.jsdelivr.com/projects/respond
	],
];