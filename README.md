![Monkyz](https://raw.githubusercontent.com/lab1353/monkyz/master/assets/images/logo/monkyz_dark_80.png)

![screenshot](https://raw.githubusercontent.com/lab1353/monkyz/master/resources/assets/images/readme/screenshot.png)

# ![monkyz logo](https://raw.githubusercontent.com/lab1353/monkyz/master/assets/images/logo/monkyz_24.png) Monkyz :: dynamic admin panel

[![lab1353](https://img.shields.io/badge/powered%20by-lab1353-brightgreen.svg)](http://1353.it)
[![Total Downloads](https://poser.pugx.org/lab1353/monkyz/downloads)](https://packagist.org/packages/lab1353/monkyz)
[![Latest Stable Version](https://poser.pugx.org/lab1353/monkyz/v/stable)](https://packagist.org/packages/lab1353/monkyz)
[![Latest Unstable Version](https://poser.pugx.org/lab1353/monkyz/v/unstable)](https://packagist.org/packages/lab1353/monkyz)
[![License](https://poser.pugx.org/lab1353/monkyz/license)](https://packagist.org/packages/lab1353/monkyz)

**Monkyz** is a dynamic and autonomous Administration Panel for *Laravel 5.2* .

It adapts to existing database by creating a full CRUD management for any table existing.
No configuration required: without writing a single line of code, your control panel is ready for use.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
  - [General Informations](#general-informations)
    - [Assets Files](#assets-files)
    - [Tables Relationships](#tables-relationships)
- [Configuration](#configuration)
  - [File `monkyz.php`](#file-monkyzphp)
  - [File `monkyz-tables.php`](#file-monkyz-tablesphp)
    - [Parameter `tables`](#parameter-tables)
    	- [Table Parameters](#table-parameters)
    	- [Fields Parameters](#fields-parameters)
- [Authentication](#authentication)
- [Artisan Commands](#artisan-commands)
  - [`monkyz:tables`](#monkyztables)
- [Customize](#customize)
  - [Custom Fields](#custom-fields)
- [Google Analytics](#google-analytics)
- [Troubleshooting](#troubleshooting)
- [Change Log](#change-log)
- [Into The Future](#into-the-future)
- [Credits](#credits)
  - [Links](#links)
  - [Vendors](#vendors)
  - [Tools](#tools)
- [Copyright and License](#copyright-and-license)

## Requirements

The requirements are:

- PHP >= 5.5.9
- Laravel 5.2

## Installation

First, pull in the package through Composer:

```bash
php composer.phar require lab1353/monkyz
```

or, for the latest version, in development (it may not be stable):

```bash
php composer.phar require lab1353/monkyz:dev-master
```

And then, within `config/app.php`, include the service provider:

```php
'providers' => [
	Lab1353\Monkyz\MonkyzServiceProvider::class,
];
```

Finally, publish the assets:

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\MonkyzServiceProvider"
```

This command will publish:

- views in: `resources/views/vendor/monkyz/`
- configuration files: `config/`
- assets: `public/vendor/monkyz/`

### General Informations

#### Assets Files

The file `css/monkyz.min.css` was generated by a SCSS file.
If you are interested in changing the SCSS source files, you can find here: `vendor/lab1353/monkyz/resources/assets/scss/`.

The file `public/vendor/monkyz/js/monkyz.min.js` has been compressed.
The original files are in: `vendor/lab1353/monkyz/resources/assets/js/`.

#### Tables Relationships

Relations between tables must follow directions imposed by Eloquent. For more information read the section [Eloquent: Relationships](https://laravel.com/docs/5.2/eloquent-relationships)

> **Monkyz** currently only supports one-to-one and many-to-one relationships.

## Configuration

### File `monkyz.php`

The file `config/monkyz.php` contains the configuration details of **Monkyz**:

- `prefix`: prefix of url for access at **Monkyz**
- `use_https` (true|false): force chema https
- `use_auth` (true|false): laravel authentication, otherwise access to panel is automatically
- `cache_minutes`: minutes of duration of cache
- `path_public_temp`: folder name, in `public` path, for temporary files
- `vendors`: array for define [vendors assets](#vendors) version

### File `monkyz-tables.php`

The file `config/monkyz-tables.php` contains parameters for generate the dynamic configuration of the DB structure:

- `input_from_type`: array to find the relative input according to the field type defined on the database
- `input_from_name`: array to find the relative input according to the name of field
- `fields_name_hide_in_edit`: array of field's name that will be hidden in edit (such as: created_at, updated_at, deleted_at)
- `tables`: [view the details](#parameter-tables)

This file can be automatically generated with the [artisan command `monkyz:generate-db`](#artisan-commands)

#### Parameter `tables`

The `tables` parameter are the ovveride array of dynamic DB structure:

```php
'table_name'	=> [	// name of table in db
	'title'	=> 'Table',
	'icon'	=> 'fa fa-table fa-fw',
	'visible'	=> true,
  'ajax_list' => false,
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
				'resize'	=> false,
				'resize_height_px'	=> 1000,
				'resize_width_px'	=> 1000,
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
- `ajax_list` (true|false): defines whether to activate the ajax paging and filtering
- `fields`: list of fields in table

##### Fields parameters

- `title`: title of column
- `input`: The values for this parameter are:
  - `block`: the `<pre>` block to display formatted text
  - `checkbox`: checkbox true/false
  - `color`: hex color selector (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `date`: only date tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `datetime`: date and time (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `editor`: a simple wysiwyg editor (used [Bootstrap3 Wysiwyg](https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/))
  - `enum`: select box for enum (mandatory to define the parameter `enum`)
  - `file`: file upload (mandatory to define the parameter `file`)
  - `hidden`: field hidden used, by default, to the key fields
  - `image`: file upload for only image (accepted extensions: .jpg, .jpeg, .png) (mandatory to define the parameter `file`)
  - `number`: number tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `relation`: select box with the relation with another table (mandatory to define the parameter `relation`)
  - `tel`: telephone number (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - `text`: text tag for string
  - `textarea`: textarea tag
  - `url`: url tag (for details see: [W3C HTML Forms](http://www.w3schools.com/html/html_forms.asp))
  - (You can create [your own custom fields](#custom-fields))
- `in_list` (true|false): visibility in list
- `in_edit` (true|false): visibility in edit and add record
- `enum`: array `'key' => 'value'` for populate the select box
- `file`: file/image field details
  - `disk`: disk name for `Storage` class, configured in config files `filesystems.php` (for more info see [Laravel Filesystem Documentation](https://laravel.com/docs/5.2/filesystem))
  - `path`: relative path of images uploaded
  - `overwrite` (true|false): overwrite the file if it already exists
  - `resize` (true|false): if field is a image, determines if the uploaded image will be resized
  - `resize_height_px`: pixel in height for resize image
  - `resize_width_px`: pixel in width for resize image
- `relation`: relationship field details
  - `table`: name of relationship's table
  - `field_value`: name of value field of relationship's table
  - `field_text`: name of text field of relationship's table
- `attributes`: array (`'key' => 'value'`) of extra attributes in input

In automatically search for the type of the field input, it is to be more important to the `input_from_name` parameter rather than a `input_from_type`.

> **!!! ATTENTION !!!**
> **Monkyz** currently only supports one-to-one and many-to-one relationships.
> All tables of many-to-many relationship will have to be defined in [config file `monkyz-tables.php`](#table-parameters) and setting the parameter `visible` to `false`.

## Authentication

You can decide whether or not to use authentication to access the administration panel.
You can define it with `use_auth` parameter in the configuration [file `monkyz.php`](#file-monkyzphp).

If `use_auth` parameters is `true`, **Monkyz** uses [Laravel authentication](https://laravel.com/docs/5.2/authentication).
If you want to use auth, you can run artisan command `php artisan make:auth`.

Otherwise, if `use_auth` is `false`, the access to **Monkyz** is automatic.

## Artisan Commands

### `monkyz:tables`

**Monkyz** provides the artisan command:

```bash
php artisan monkyz:tables
```

This command allows you to automatically fill in the [`monkyz-tables.php` config file](#file-monkyz-tablesphp).

It will automatically create all the necessary references to **Monkyz** for the db structure.
Not overwrite already entered parameters: only add the parameters have not been set.

## Customize

### Custom Fields

**Monkyz** allows the creation of types of custom fields in the edit page of the record.

To create it, follow these steps:

1) If you have not already done so, to publish the views:

```bash
php artisan vendor:publish --provider="Lab1353\Monkyz\Providers\MonkyzServiceProvider"
```

The following command will be published the views files in: `/resources/views/vendor/monkyz`

2) Go to the `resources/views/vendor/monkyz/` folder and create a new [file blade](https://www.laravel.com/docs/5.2/blade),
appointing him as your new field (for example: `custom`):

```bash
cd resources/views/vendor/monkyz
touch custom.blade.php
```

You can add css references using the section `css`:

```
@section('css')
  @parent

  <link rel="stylesheet" href="..." />
@endsection
```

or js with the section `scripts`:

```
@section('scripts')
  @parent

  <script type="text/javascript" src="..."></script>
@endsection
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
			'input'	=> 'custom',	// <-- change 'custom' with your custom field name
```

## Google Analytics

In the dashboard, you can view the statistics taken from Google Analytics.

**Monkyz** used [spatie/laravel-analytics](https://github.com/spatie/laravel-analytics) package that requires a particular configuration to be able to retrieve data from Google Analytics.

You have to follow the [official guide](https://github.com/spatie/laravel-analytics#getting-credentials) to create the file `storage/app/laravel-google-analytics/service-account-credentials.json`.
Once you create the file, set the `viewId` parameter in the Settings page.

## Troubleshooting

To report a issues, use [GitHub Issues](https://github.com/lab1353/monkyz/issues).

For help with common problems, see [`ISSUES.md`](https://github.com/lab1353/monkyz/blob/master/ISSUES.md).

## Change Log

Please see [`CHANGELOG.md`](https://github.com/lab1353/monkyz/blob/master/CHANGELOG.md) for more information what has changed recently.

## Into The Future

- compatibility with Laravel 5.4
- import/export configurations
- manage useSoftDelete in model
- roles for access sections
- [Laravel validation rules](https://laravel.com/docs/5.2/validation) for fields
- multi files uploads

## Credits

### Links

- [1353](http://1353.it/)
- [Packagist](https://packagist.org/packages/lab1353/monkyz)
- [Packalyst](http://packalyst.com/packages/package/lab1353/monkyz)
- [GitHub](https://github.com/lab1353/monkyz)

### Vendors

**Monkyz** was made using the following css/js:

- [Bootstrap](http://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [DataTables](https://datatables.net/)
- [Pace](http://github.hubspot.com/pace/docs/welcome/)
- [Google Fonts](https://fonts.google.com/)
- [Font Awesome](http://fontawesome.io/)
- [Paper Dashboard](http://www.creative-tim.com/product/paper-dashboard)
- [Bootstrap3 Wysiwyg](https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/)

All vendors files are loaded in CDN.

### Tools

- [wimg.ca](http://wimg.ca)

## Copyright and License

**Monkyz** was written by **Daniele Montecchi** of [**lab1353**](http://1353.it).

**Monkyz** is released under the MIT License. See the [`LICENSE.md` file](https://github.com/lab1353/monkyz/blob/master/LICENSE.md) for details.
