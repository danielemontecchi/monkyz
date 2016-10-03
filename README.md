![Monkyz](https://raw.githubusercontent.com/lab1353/monkyz/master/assets/images/logo/monkyz_logo_grey_100.png)

> **!!! ATTENTION !!!**
> This package is in development to complete at a first working version. Do not install it yet, but come to see us often to find out when it is released :)

# ![monkyz logo](https://raw.githubusercontent.com/lab1353/monkyz/master/assets/images/logo/monkyz_24.png) Monkyz [![lab1353](https://img.shields.io/badge/powered%20by-lab1353-brightgreen.svg)](http://1353.it)

**Monkyz** is a dynamic and autonomous Administration Panel for *Laravel 5.2* .

It adapts to existing database by creating a full CRUD management for any table existing.
No configuration required: without writing a single line of code, your control panel is ready for use.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
  - [Information for assets files](#information-for-assets-files)
- [Configuration](#configuration)
  - [File `monkyz`](#file-monkyz)
  - [File `monkyz-db`](#file-monkyz-db)
    - [Parameter `tables`](#parameter-tables)
    	- [Table Parameters](#table-parameters)
    	- [Fields Parameters](#fields-parameters)
- [Artisan Command](#artisan-command)
- [Creating Custom Fields](#creating-custom-fields)
- [Known Issues](#known-issues)
- [Future Additions](#future-additions)
- [Credits](#credits)
  - [Vendors](#vendors)
- [Copyright and License](#copyright-and-license)

## Requirements

The requirements are:

- PHP >= 5.5.9
- Laravel 5.2

### Optional

**Monkyz** gives the option to not use the log in to access the administration panel.
If you want to have user authentication before accessing the administration panel, then you must create the `users` table using `migrations` that Laravel has inside.

For more information read the [documentation Laravel](https://www.laravel.com/docs/5.2/authentication).

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

The following files will be published with the commands `php artisan vendor:publish`:

- views in: `/resources/views/vendor/monkyz`
- configuration files: `/config/lab1353/monkyz`
- assets: `/public/vendor/monkyz`

### Information for assets files

The file `css/monkyz.min.css` was generated by a LESS file.
If you are interested in changing the LESS source files, you can find here: `/vendor/lab1353/monkyz/resources/assets/less/monkyz.less`.

The file `js/monkyz.min.js` has been compressed.
The original file are: `/vendor/lab1353/monkyz/resources/assets/js/monkyz.js`.

## Configuration

### File `monkyz`

The file `config/monkyz.php` contains the configuration details of **Monkyz**:

- `prefix`: prefix of url for access at **Monkyz**
- `use_https` (true|false): force chema https
- `cache_minutes`: minutes of duration of cache
- `path_public_temp`: folder name, in `public` path, for temporary files

### File `monkyz-db`

The file `config/monkyz-db.php` contains parameters for generate the dynamic configuration of the DB structure:

- `input_from_type`: array to find the relative input according to the field type defined on the database
- `input_from_name`: array to find the relative input according to the name of field
- `fields_name_hide_in_edit`: array of field's name that will be hidden in edit (such as: created_at, updated_at, deleted_at)
- `tables`: [view the details](#parameter-tables)

This file can be automatically generated with the [artisan command `monkyz:generate-db`](#artisan-command)

#### Parameter `tables`

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
			'enum'	=> [
				'attr'	=> 'value'
			]
			'file'	=> [
				'disk'	=> 'local',
				'path'	=> 'uploads/',
				'overwrite'	=> true,
			],
			'image'	=> [
				'disk'	=> 'local',
				'path'	=> 'uploads/',
				'overwrite'	=> true,
				'resize'	=> false,
			],
			'relation'	=> [
				'table'	=> 'table2',
				'field_value'	=> 'id',
				'field_text'	=> 'name',
			],
			'attributes'	=> [
				'attr'	=> 'value'
			]
		]
	]
],
```

##### Table parameters

- `title`: title of table
- `icon`: the [fontawesome icon](http://fontawesome.io/icons/)
- `visible` (true|false): visibility of table in the sidebar menù
- `fields`: list of fields in table

##### Fields parameters

- `title`: title of column
- `input`: The values for this parameter are:
  - `block`: the `<pre>` block to display the value
  - `checkbox`: checkbox true/false
  - `color`: hex color selector (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `date`: only date tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `datetime`: date and time (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `enum`: select box for enum (mandatory to define the parameter `enum`)
  - `file`: file upload (mandatory to define the parameter `file`)
  - `hidden`: field hidden used, by default, to the key fields
  - `image`: file upload for only image (accepted extensions: .jpg, .jpeg, .png) (mandatory to define the parameter `image`)
  - `number`: number tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `relation`: select box with the relation with another table (mandatory to define the parameter `relation`)
  - `tel`: telephone number (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `text`: text tag for string
  - `textarea`: textarea tag
  - `url`: url tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - (You can create [your own custom fields](#creating-custom-fields))
- `in_list` (true|false): visibility in list
- `in_edit` (true|false): visibility in edit and add record
- `enum`: array `'key' => 'value'` for populate the select box
- `file`: file details
  - `disk`: disk name for `Storage` class, configured in config files `filesystems.php` (for more info see [Laravel Filesystem Documentation](https://laravel.com/docs/5.2/filesystem))
  - `path`: relative path of files uploaded
  - `overwrite` (true|false): overwrite the file if it already exists
- `image`: image details
  - `disk`: disk name for `Storage` class, configured in config files `filesystems.php` (for more info see [Laravel Filesystem Documentation](https://laravel.com/docs/5.2/filesystem))
  - `path`: relative path of images uploaded
  - `overwrite` (true|false): overwrite the file if it already exists
  - `resize` (true|false): It determines if the uploaded image will be resized
- `relation`: relationship details
  - `table`: name of relationship's table
  - `field_value`: name of value field of relationship's table
  - `field_text`: name of text field of relationship's table
- `attributes`: array (`'key' => 'value'`) of extra attributes in input

In automatically search for the type of the field input, it is to be more important to the `input_from_name` parameter rather than a `input_from_type`.

> **!!! ATTENTION !!!**
> **Monkyz** currently only supports one-to-one and many-to-one relationships.
> All tables of many-to-many relationship will have to be defined in [config file `monkyz-db.php`](#table-parameters) and setting the parameter `visible` to `false`.

## Artisan Command

**Monkyz** provides the artisan command:

```bash
php artisan monkyz:generate-db
```

This command allows you to automatically fill in the [`monkyz-db.php` config file](#file-monkyz-db).

It will automatically create all the necessary references to **Monkyz** for the db structure.
Not overwrite already entered parameters: only add the parameters have not been set.

## Creating Custom Fields

**Monkyz** allows the creation of types of custom fields in the edit page of the record.

To create it, follow these steps:

1) If you have not already done so, to publish the views:

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider"
```

The following command will be published the views files in: `/resources/views/vendor/monkyz`

2) Go to the `/resources/views/vendor/monkyz` folder and create a new [file blade](https://www.laravel.com/docs/5.2/blade),
appointing him as your new field (for example: `custom`):

```bash
cd resources/views/vendor/monkyz
touch custom.blade.php
```

3) Edit the new file as you prefer. Know that, the view, the following variables are passed:

- `$field`: name of database column
- `$record`: the [Eloquent Model](https://www.laravel.com/docs/5.2/eloquent) (to retrieve the value of the field then use: `$record->$field`)
- `$params`: array of field parameters

4) Now you can use your personal type of field, setting the parameter of the `input` fields:

```php
'table_name'	=> [	// name of table in db
	'fields'	=> [
		'field_name'	=> [	// name of field in db
			'input'	=> 'custom',
```

## Known Issues

To report a issues, use [GitHub Issues](https://github.com/lab1353/monkyz/issues).

These are the known issues that will be resolved on the next versions:

- relationships: Monkeyz currently only supports one-to-one and many-to-one relationships

## Future Additions

- manage useSoftDelete
- compatibility with [Laravel 5.3](https://laravel.com/docs/5.3/upgrade#upgrade-5.3.0)
- dynamic settings
- [Laravel validation rules](https://laravel.com/docs/5.2/validation) for fields
- roles for access sections
- multi files uploads
- integrate [Bootstrap Select](https://silviomoreto.github.io/bootstrap-select/examples/)
- integrate [Bootstrap Switch](http://www.bootstrap-switch.org/)
- widgets, counters and graph
- integrate [Google Analytics](https://www.google.com/analytics/)

## Credits

### Vendors

**Monkyz** was made using the following css/js:

- [Laravel](https://laravel.com/)
- [Bootstrap](http://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [DataTables](https://datatables.net/)
- [Pace](http://github.hubspot.com/pace/docs/welcome/)
- [metisMenu](https://github.com/onokumus/metisMenu)
- [Lazy Load Plugin for jQuery](http://www.appelsiini.net/projects/lazyload)
- [Google Fonts](https://fonts.google.com/)
- [Font Awesome](http://fontawesome.io/)

All vendors files are load with CDN.

## Copyright and License

Administrator was written by **Daniele Montecchi** of [**lab1353**](http://1353.it).

Administrator is released under the MIT License. See the [`LICENSE.md` file](https://github.com/lab1353/monkyz/blob/master/LICENSE.md) for details.