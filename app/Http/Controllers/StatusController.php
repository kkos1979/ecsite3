<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Mail\OrderShipped; //
use App\Rules\Tel; // カスタムバリデーションルールTelを使用。
use Gate; // Gateを使用
use Illuminate\Support\Facades\Mail; // Mailファサードの使用
use App\Http\Requests\AddressPost; // フォームリクエストによるバリデーション

class StatusController extends Controller
{
    public function index() {
      $items = Item::all();
      // 管理者でログインしたら管理者ホームへリダイレクト
      if (Gate::allows('isAdmin')) {
        return redirect()->action('AdminController@index');
      } else {
        return view('index', ['items' => $items]);
      }
    }
}
