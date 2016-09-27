![Monkyz](assets/images/logo/monkyz_logo_large.png)

# ![monkyz logo](assets/images/logo/monkyz_24.png) Monkyz
[![lab1353](https://img.shields.io/badge/powered-lab1353-brightgreen.svg)](http://1353.it)

---

**Monkyz** is a dynamic administrative panel to *Laravel 5.x* .

It adapts to existing database by creating a full CRUD management for any table.
No configuration required: without writing a single line of code, your control panel is ready for use.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Credits](#credits)
- [License](#license)

## Installation

First, pull in the package through Composer.

```bash
composer require lab1353/monkyz:dev-master
```

And then, within `config/app.php`, include the service provider.

```php
'providers' => [
    Lab1353\Monkyz\Providers\MonkyzServiceProvider::class,
];
```

Finally, publish the assets:

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider"
```

## Configuration

The file `config/lab1353/monkyz/main.php` contains the configuration details of **Monkyz**:

- `prefix`: prefix of url for access at **Monkyz**
- `input_from_type`: array to find the relative input according to the field type defined on the database
- `input_from_name`: array to find the relative input according to the name of field
- `override_db_configuration`: parameter to overwrite dynamic configuration of tables and database fields

### Parameter `override_db_configuration`

This parameter overrides the dynamic configuration of tables and fields.

```php
 'table_name'	=> [	// name of table in db
 	'title'	=> 'Table',	// title of table
 	'icon'	=> 'fa fa-table fa-fw',	// the fontawesome icon
 	'visible'	=> true,	// visibility of table
 	'fields'	=> [	// list of fields
 		'field_name'	=> [	// name of field in db
 			'title'	=> 'Column',	// title of column
 			'input'	=> 'text',	// input tag type
 			'source_table'	=> 'table2',	// name of relationship's table
 			'source_field'	=> 'name',	// name of string of relationship's table
 			'in_list'	=> true,	// visibility in list
 			'in_edit'	=> true,	// visibility in edit and add
 		]
 	]
 ]
```

## Credits

This package has been realized by [lab1353](http://1353.it)

## License

The MIT License (MIT)

Copyright (c) 2016 [lab1353](http://1353.it)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## Commands for developer

**Force publish assets**

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider" --force
```

**Generate LESS**

```bash
lessc --clean-css packages/lab1353/monkyz/assets/less/monkyz.less public/vendor/lab1353/monkyz/css/monkyz.min.css
lessc --clean-css packages/lab1353/monkyz/assets/less/monkyz.less packages/lab1353/monkyz/assets/css/monkyz.min.css
```