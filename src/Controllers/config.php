<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
	'callback' => 'http://localhost:7777/login/github',
	'providers' => [
		'Github' => [
            'enabled' => true,
            'keys' => [
                'id' => $_ENV['HUB_ID'],
                'secret' => $_ENV['HUB_SECRET'],
            ],
		]
	],
];
