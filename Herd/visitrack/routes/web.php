<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home_view');
});

Route::get('/login', function () { //Url
    return view('login_view'); //File Name
});

Route::get('/registration', function (){
    return view('registration_view');
});