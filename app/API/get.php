<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html/');
$dotenv->load();

if($_SERVER['HTTP_VOST_AUTH'] !== $_ENV['VOST_AUTH']){
    $response = [
        'msg' => 'no auth',
        'code' => 403
    ];
    \Lib\Response::json($response, 403);
    die();
}

$data = \Lib\DataStore::getLastLocations();

\Lib\Response::json($data,200);