<?php
namespace App\Middlewares;

use System\Http\Middleware;

$appMiddleware = new Middleware();

$appMiddleware -> before(function () {
    echo "funtion 1";
});

$appMiddleware -> before(function () {
    echo "funtion 2";
});

$appMiddleware -> before(function () {
    echo "funtion 3";
});