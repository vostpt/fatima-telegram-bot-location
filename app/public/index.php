<?php
require_once '../vendor/autoload.php';
use Steampixel\Route;

Route::add('/', function() {
    include '../templates/_index.php';
});

Route::add('/api/webhook', function() {
    include '../API/webhook.php';
}, 'post');

Route::add('/api/get', function() {
    include '../API/get.php';
});

Route::run('/');