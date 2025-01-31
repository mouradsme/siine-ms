<?php

Route::get('/', function() {
    return view('portal');
});
include __DIR__ . '/microservices/users_viewer.php'; //