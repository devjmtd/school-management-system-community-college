<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf/matriculation/{enrollment}', function (\App\Models\Enrollment $enrollment) {
    return view('pdfs.matriculation', compact('enrollment'));
});