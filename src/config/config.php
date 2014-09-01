<?php

/*
 |--------------------------------------------------------------------------
 | Clumsy CMS settings
 |--------------------------------------------------------------------------
 |
 |
 */

return array(

    /*
     |--------------------------------------------------------------------------
     | Fail silently
     |--------------------------------------------------------------------------
     |
     | Whether to throw exceptions for errors like 404 or token mismatch or
     | handle them via redirects or error messages.
     |
     */

    'silent' => !Config::get('app.debug'),

    /*
     |--------------------------------------------------------------------------
     | Admin prefix
     |--------------------------------------------------------------------------
     |
     | URL prefix that points to the admin area of your CMS
     | i.e. http://example.com/admin/
     |
     */

	'admin_prefix' => 'admin',

    /*
     |--------------------------------------------------------------------------
     | Default columns
     |--------------------------------------------------------------------------
     |
     | Which columns should be shown on resource tables on admin area, if
     | no columns are manually set
     |
     */

    'default_columns' => array('title' => trans('clumsy/cms::fields.title')),

    /*
     |--------------------------------------------------------------------------
     | Default items per page
     |--------------------------------------------------------------------------
     |
     | How many items of a given resource should be shown per page. You can
     | also override this on each model by defining an "admin_per_page"
     | property.
     |
     | To disable paging, set to 'false'.
     |
     */

    'per_page' => 50,
);