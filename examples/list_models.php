#!/usr/bin/env php

<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$page = $client->models->list();

var_dump($page);
