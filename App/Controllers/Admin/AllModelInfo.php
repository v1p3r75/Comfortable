<?php
namespace App\Controllers\Admin;

$tablesInfo = [
	'hiddenTables' => ['banned','config'],
];

$modelsData = [

	'users' => [
		'primaryKey' => 'user_id',
		'ignoredFields' => ['user_id']
	],
	'user' => [
		'primaryKey' => 'id',  'create_at' => 'date_creation', 'update_at' => 'date_edition',
		'ignoredFields' => ['id','date_creation','date_edition'],
		'form' => [ // List of Table columns and their type input
			'names' => [
				'type' => 'text',
				'minSize' => null,
				'maxSize' => null,
				'placeholder' => null,
				'attributes' => '',
			],
			'num' => [
				'type' => 'number',
			],
			'email' => [
				'type' => 'email',
			],
		]
	],
];
