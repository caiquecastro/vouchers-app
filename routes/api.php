<?php

use Illuminate\Http\Request;

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

$router->post('/vouchers/{voucher}/redeem', 'VouchersController@redeem');
$router->get('/recipients/{recipient}/vouchers', 'RecipientVouchersController@index');
