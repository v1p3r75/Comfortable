<?php

/**
 * Your App Configuration
 * 
 */

$appVar = [

	/* APP INFORMATION 	*/
	'APP_NAME' => 'fortify',
	'APP_AUTHOR' => 'viper75',

	/* ENVIRONMENT */
	'ENV_TYPE' => 'development',
	'SITE_TYPE' => 'web',

    /* DATABASE INFORMATION */
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'fv_api2',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => '',
    'DB_CHARSET' => 'utf8',
	'DB_PERSISTENT' => true,

    /* PATH CONFIGURATION */
    'ASSETS_PATH' => '/public/',
    'VIEW_PATH' => __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR,
    'ADMINS_IMG' => __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR,

    /* DATE CONFIG */

    'TIMEZONE' => 'Africa/Porto-Novo',
];