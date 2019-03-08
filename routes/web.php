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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/access_token' , 'Weixin\WeixinController@getAccessToken');


Route::get('/weixin/valid1','Weixin\WeixinController@validToken1');
Route::post('/weixin/valid1','Weixin\WeixinController@wxEvent');        //接收微信服务器事件推送
Route::get('/index','Weixin\WeixinController@getUserInfo');

Route::get('/menu','Weixin\WeixinController@menu');

Route::get('/delmenu','Weixin\WeixinController@delmenu');