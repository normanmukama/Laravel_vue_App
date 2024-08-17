<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');

// Route::get('/contacts', function () {
//     $contacts = app('app.data')['contacts'];
//     return response()->json($contacts);
// });

Route::get('/test-logging', function () {
    Log::debug('This is a test debug message.');
    return 'Check your logs!';
});

