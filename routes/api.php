<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users', 'App\Http\Controllers\UserController@store');
Route::get('/login', 'App\Http\Controllers\UserController@login');


Route::post('/tickets', 'App\Http\Controllers\TicketController@store');

Route::get('/tickets', 'App\Http\Controllers\TicketController@getTickets');
Route::post('/tickets/{id}', 'App\Http\Controllers\TicketController@updateTicket');

