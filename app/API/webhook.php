<?php
require_once '../vendor/autoload.php';


$request = json_decode(file_get_contents( 'php://input' ));

print_r($request);

if(isset($request->message->location)){
    \Lib\DataStore::save($request);
}

