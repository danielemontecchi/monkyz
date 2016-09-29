![Monkyz](assets/images/logo/monkyz_logo_grey_100.png)

# ![monkyz logo](assets/images/logo/monkyz_24.png) Monkyz [![lab1353](https://img.shields.io/badge/powered%20by-lab1353-brightgreen.svg)](http://1353.it)

**Monkyz** is a dynamic and autonomous Administration Panel for *Laravel 5.2* .

It adapts to existing database by creating a full CRUD management for any table existing.
No configuration required: without writing a single line of code, your control panel is ready for use.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
  - [File `main`](#file-main)
  - [File `db`](#file-db)
    - [`tables` Parameter](tables-parameter)
- [Known Issues](#known-issues)
- [Future Additions](#future-additions)
- [Credits](#credits)
  - [Vendors](#vendors)
- [License](#license)

## Requirements

The requirements are:

- PHP >= 5.5.9
- Laravel 5.2

## Installation

First, pull in the package through Composer:

```bash
php composer.phar require lab1353/monkyz
```

or, for the latest version, in development:

```bash
php composer.phar require lab1353/monkyz:dev-master
```

And then, within `config/app.php`, include the service provider:

```php
'providers' => [
	Lab1353\Monkyz\Providers\MonkyzServiceProvider::class,
];
```

Finally, publish the assets:

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider"
```

The following files will be published:

- views in: `/resources/views/vendor/lab1353/monkyz`
- configuration files: `/config/lab1353/monkyz`
- assets: `/public/vendor/lab1353/monkyz`

## Configuration

### File `main`

The file `config/lab1353/monkyz/main.php` contains the configuration details of **Monkyz**:

- `prefix`: prefix of url for access at **Monkyz**

### File `db`

The file `config/lab1353/monkyz/db.php` contains parameters for generate the dynamic configuration of the DB structure:

- `input_from_type`: array to find the relative input according to the field type defined on the database
- `input_from_name`: array to find the relative input according to the name of field
- `fields_name_hide_in_edit`: array of field's name that will be hidden in edit (such as: created_at, updated_at, deleted_at)
- `tables`: [view the details](#tables-parameter)

#### `tables` Parameter

The `tables` parameter are the ovveride array of dynamic DB structure:

```php
'table_name'	=> [	// name of table in db
	'title'	=> 'Table',
	'icon'	=> 'fa fa-table fa-fw',
	'visible'	=> true,
	'fields'	=> [
		'field_name'	=> [	// name of field in db
			'title'	=> 'Column',
			'input'	=> 'text',
			'in_list'	=> true,
			'in_edit'	=> true,
			'image'	=> [
				'path'	=> 'upload/',
			],
			'relationship'	=> [
				'table'	=> 'table2',
				'field_value'	=> 'id',
				'field_text'	=> 'name',
			],
			'attributes'	=> [
				'class'	=> 'mycss'
			]
		]
	]
],
```

**Table parameters**

- `title`: title of table
- `icon`: the [fontawesome icon](http://fontawesome.io/icons/)
- `visible` (true|false): visibility of table in the sidebar menù
- `fields`: list of fields in table

**Field parameters**

- `title`: title of column
- `input`: The input types are:
  - `block`: the `<pre>` block to display the value
  - `checkbox`: checkbox true/false
  - `color`: hex color selector (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `date`: only date tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `datetime`: date and time (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `file`: file upload
  - `hidden`: field hidden used, by default, to the key fields
  - `image`: file upload for only image (accepted extensions: .jpg, .jpeg, .png)
  - `number`: number tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `select`: select tag for relationships
  - `tel`: telephone number (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `text`: text tag for string
  - `url`: url tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
- `in_list` (true|false): visibility in list
- `in_edit` (true|false): visibility in edit and add record
- `image`: image details
  - `path`: path of images uploaded
- `relationship`: relationship details
  - `table`: name of relationship's table
  - `field_value`: name of value field of relationship's table
  - `field_text`: name of text field of relationship's table
- `attributes`: array (`'key' => 'value'`) of extra attributes in input

> ATTENTION!!! Monkeyz currently only supports one-to-one and many-to-one relationships

## Known Issues

To report a issues, use [GitHub Issues](https://github.com/lab1353/monkyz/issues).

These are the known issues that will be resolved on the next versions:

- relationships: Monkeyz currently only supports one-to-one and many-to-one relationships

## Future Additions

- compatibility with [Laravel 5.3](https://laravel.com/docs/5.3/upgrade#upgrade-5.3.0)
- settings
- [Laravel validation rules](https://laravel.com/docs/5.2/validation) for fields
- Artisan commands for generate automatically the `db.php` configuration file
- roles for access sections
- multi files uploads
- integrate [Bootstrap Select](https://silviomoreto.github.io/bootstrap-select/examples/)
- integrate [Bootstrap Switch](http://www.bootstrap-switch.org/)
- widgets, counters and graph
- integrate [Google Analytics](https://www.google.com/analytics/)

## Credits

**Monkyz** package has been realized by [**lab1353**](http://1353.it)

### Vendors

**Monkyz** was made using the following css/js:

- [Laravel](https://laravel.com/)
- [Bootstrap](http://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [DataTables](https://datatables.net/)
- [metisMenu](https://github.com/onokumus/metisMenu)
- [Lazy Load Plugin for jQuery](http://www.appelsiini.net/projects/lazyload)
- [Google Fonts](https://fonts.google.com/)
- [Font Awesome](http://fontawesome.io/)

All vendors files are load with CDN.

## License

The MIT License (MIT)

Copyright (c) 2016 [**lab1353**](http://1353.it)

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