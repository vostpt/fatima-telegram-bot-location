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

$channelId = isset($_GET['channelId']) ? (int) $_GET['channelId'] : false;
$data = \Lib\DataStore::getLastLocations($channelId);

\Lib\Response::json($data,200);
