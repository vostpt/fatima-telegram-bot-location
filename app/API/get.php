<?php
require_once '../vendor/autoload.php';


$data = \Lib\DataStore::getLastLocations();

\Lib\Response::json($data,200);