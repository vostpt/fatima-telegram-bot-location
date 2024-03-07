<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html/');
$dotenv->load();

if(!isset($_SERVER['HTTP_VOST_AUTH']) || $_SERVER['HTTP_VOST_AUTH'] !== $_ENV['VOST_AUTH']){
    $response = [
        'msg' => 'no auth',
        'code' => 403
    ];
    \Lib\Response::json($response, 403);
    die();
}

$data = \Lib\DataStore::getReports();

\Lib\Response::json($data,200);
