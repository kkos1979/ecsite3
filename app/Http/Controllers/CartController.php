<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Purchase;
use App\Purchasedetail;
use App\Mail\OrderShipped; //
use Gate; // Gateを使用
use Illuminate\Support\Facades\Mail; // Mailファサードの使用
use App\Http\Requests\AddressPost; // フォームリクエストによるバリデーション
use Illuminate\Support\Facades\Auth; // Authファサードの使用

class CartController extends Controller
{
    //
    public function cartPost(Request $request) {

      $rows = [];
      $errors_over = [];
      $sum = 0;

      if (!$request->session()->has('cart')) {
        $request->session()->put('cart', []);
      }

      // リクエストからトークンを除く
      $inputs = $request->except('_token');
      // セッションに商品IDと注文数量を保存
      foreach ($inputs as $key => $value) {
        $id = str_replace('num_', '', $key);
        if (!$request->session()->has('cart.' . $id)) {
          $request->session()->put('cart.' . $id, 0);
        }
        // 注文数量の更新（もっと簡易な方法は？）
        $g_num = $request->session()->get('cart.' . $id);
        $g_num += $value;
        $request->session()->put('cart.' . $id, $g_num);
      }

      //商品情報の表示
      $cart = $request->session()->get('cart');
      foreach ($cart as $id => $num) {

        $row = Item::where('id', '=', $id)->first();
        if ($num !== 0) {
            $row->num = strip_tags($num);
            $sum += $num * $row->price;
            $rows[] = $row;
        }
        if (isset($row->num) && $row->num > $row->stock) {
          $errors_over[] = "{$row->name}の購入希望数が在庫数を超えています。\n購入希望数を減らしてください。";
        }
      }

      // 二重送信対策(なぜこれで、cart/indexに$rowsが表示されるのか？)
      return redirect('cart')->withInput();
      // return view('cart.index', ['rows' => $rows, 'errors_over' => $errors_over, 'sum' => $sum]);
    }

    public function cartGet(Request $request) {

      $rows = [];
      $sum = 0;
      $errors_over = [];

      if (!$request->session()->has('cart')) {
        $request->session()->put('cart', []);
      }

      //保存したセッション情報を取得
      $cart = $request->session()->get('cart');
      foreach ($cart as $id => $num) {
        $row = Item::where('id', '=', $id)->first();
        if ($num !== 0) {
            $row->num = strip_tags($num);
            $sum += $num * $row->price;
            $rows[] = $row;
        }
        if (isset($row->num) && $row->num > $row->stock) {
          $errors_over[] = "{$row->name}の購入希望数が在庫数を超えています。\n購入希望数を減らしてください。";
        }
      }

      return view('cart.index', ['rows' => $rows, 'errors_over' => $errors_over, 'sum' => $sum]);
    }

    public function empty(Request $request) {
      // セッションcartを空にする。
      $request->session()->forget('cart');
      $sum = 0;
      return view('cart.index', ['sum' => $sum]);
    }

    public function buyComplete(AddressPost $request) {

      // メールアドレスが入力されている場合バリデート
      if (isset($request->email)) {
        $rules = [
          'email' => ['email'],
        ];
        $this->validate($request, $rules);
      }

      // リロード対策
      if (!$request->session()->has('cart')) {
        $request->session()->put('cart', []);
      }

      //セッションから商品情報を取得
      $cart = $request->session()->get('cart');

      $rows = [];
      $sum = 0;
      $now = \Carbon\Carbon::now();

      foreach ($cart as $id => $num) {
        $row = Item::where('id', $id)->first();
        if ($num !== 0) {
          // 商品在庫の減少
          Item::where('id', $id)->decrement('stock', $num);

          // 販売履歴詳細への登録
          $price = $row->price;
          $latest_purchase = Purchase::select('id')->latest('id')->first();
          $purchase_id = $latest_purchase->id + 1;

          Purchasedetail::insert([
            'purchase_id' => $purchase_id,
            'item_id' => $id,
            'price' => $price * $num,
            'quantity' => $num,
            'created_at' => $now,
            'updated_at' => $now,
          ]);

          // view用データの作成
          $row->num = $num;
          $sum += $num * $row->price;
          $rows[] = $row;
        }
      }

      // 販売履歴への登録
      if (Auth::check()) {
        $user_id = Auth::id();
      } else {
        // シーダーによりゲストidは2に固定
        $user_id = 2;
      }
      Purchase::insert([
        'user_id' => $user_id,
        'total_price' => $sum,
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      // メールの送信
      if (isset($request->email)) {
        $mail_to = $request->email;
        Mail::to($mail_to)->send(new OrderShipped($request, $rows, $sum));
      }

      // セッションcartを空にする。
      $request->session()->forget('cart');
      return view('/cart/buy_complete', ['request' => $request, 'rows' => $rows, 'sum' => $sum]);
    }
}
