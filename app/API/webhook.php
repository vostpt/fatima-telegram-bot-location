<?php
require_once '../vendor/autoload.php';

function loog($msg)
{
    $log_file_data = '/var/www/html/log.log';
    file_put_contents($log_file_data, $msg . "\n", FILE_APPEND);
} 


$request = json_decode(file_get_contents( 'php://input' ));
if(isset($request->message->text) && str_starts_with($request->message->text, '/report')){
	\Lib\DataStore::saveReport($request);
}	

if(isset($request->message->location)){
    \Lib\DataStore::save($request);
}

