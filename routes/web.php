<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf/matriculation/{enrollment}', function (\App\Models\Enrollment $enrollment) {
    return view('pdfs.matriculation', compact('enrollment'));
});

Route::get('/pdf/grades', function () {
    $enrollment = \App\Models\Enrollment::find(22);
    return view('pdfs.grades', compact('enrollment'));
});

Route::get('/pdf/tor/{studentProgram}', function (\App\Models\StudentProgram $studentProgram) {
    return view('pdfs.tor', compact('studentProgram'));
});