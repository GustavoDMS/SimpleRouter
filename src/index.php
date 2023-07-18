<?php

namespace gustavodms\simplerouter;
require_once '../vendor/autoload.php';


Router::GET('teste2/{id}', function (Request $r, ResponseWriter $w) {
    $w->write($r->getQueryParam('id'));
});

Router::POST('teste/controller/{id}', [TesteController::class, 'index']);


Router::GET('teste', function () {
    echo "Teste";
});


Router::Initialize();
