<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/saludo', function (Request $request) {
return response()->json(['mensaje' => 'Hola Mundo']);
});
