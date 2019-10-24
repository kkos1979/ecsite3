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

//home
Route::get('/', 'StatusController@index');

//ユーザーの登録・認証（prefix、namespace使用）
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
  Route::get('register', 'RegisterController@showRegistrationForm');
  Route::post('register', 'RegisterController@register');

  Route::get('login', 'LoginController@showLoginForm');
  Route::post('login', 'LoginController@login');

  Route::get('logout', 'LoginController@logout');
});

// カート
Route::group(['prefix' => 'cart'], function() {
  Route::get('/', 'CartController@cartGet');
  Route::post('/', 'CartController@cartPost');
  Route::get('/empty', 'CartController@empty');
  Route::get('/buy', function(){
    return view('cart.buy');
  });
  Route::post('/buy', 'CartController@buyComplete');
});

// 管理者ホーム
Route::get('/admin', 'AdminController@index');

Route::group(['prefix' => 'admin/purchase'], function() {
  // 販売管理画面
  Route::get('/', 'PurchaseController@index');
  Route::post('/', 'PurchaseController@purchasePost');
  // 販売内容詳細画面
  Route::get('/detail/{id}', 'PurchaseController@detail');
});

Route::group(['prefix' => 'admin/items'], function() {
  // 商品管理画面
  Route::get('/', 'ItemController@index');
  // 商品編集画面
  Route::get('/edit/{id}', 'ItemController@editGet');
  Route::post('/edit/{id}', 'ItemController@editPost');
  // 画像の追加
  Route::get('/upload/{id}/{name}', 'ItemController@uploadGet');
  Route::post('/upload/{id}/upload', 'ItemController@uploadPost');
  // 商品の削除
  Route::delete('/destroy/{id}', 'ItemController@destroy');
  // 商品の新規追加
  Route::get('/create', 'ItemController@create');
  Route::post('/create', 'ItemController@store');
  // サイトの確認
  Route::get('/admin', 'ItemController@confirmIndex');
});
