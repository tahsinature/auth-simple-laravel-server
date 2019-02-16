<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     // return view('welcome');
//     return ['data' => [1, 2, 3]];
// });

// Route::get('/me', [
//     'uses' => 'ProfileController@getUser'
// ]);

Route::put('/me', [
    'uses' => 'AuthController@editUser',
    'as' => 'edit'
])->middleware(['authJWT']);

Route::post('/login', [
    'uses' => 'AuthController@loginUser',
    'as' => 'login'
]);

Route::post('/authenticate', [
    'uses' => 'AuthController@authenticateUser',
    'as' => 'authenticate'
])->middleware(['authJWT']);
    
Route::post('/register', [
    'uses' => 'AuthController@registerUser',
    'as' => 'register'
    ]);
    
    // ----
    
Route::get('/quotes', [
    'uses' => 'QuoteController@getQuotes',
    'as' => 'getQuotes'
])->middleware(['authJWT']);

Route::post('/quotes', [
    'uses' => 'QuoteController@newQuote',
    'as' => 'createQuote'
])->middleware(['authJWT']);

Route::delete('/quotes/{id}', [
    'uses' => 'QuoteController@deleteQuote',
    'as' => 'deleteQuote'
])->middleware(['authJWT']);
