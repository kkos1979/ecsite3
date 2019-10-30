<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Item;
use \App\Purchase;
use \App\Purchasedetail;
use App\Http\Requests\PurchasePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //DBファサードの使用

class PurchaseController extends Controller
{
    //
    public function index() {
      if (session()->has('start_date')) {
        $start_date = session()->get('start_date');
        $last_date = session()->get('last_date');
        $sells = Purchase::whereBetween('created_at', [$start_date, $last_date])->orderBy('created_at')->get();
      } else {
        $sells = Purchase::orderBy('created_at')->get();
      }
      $sum = $sells->sum('total_price');
      
      return view('/admin/purchase/index', ['sells' => $sells, 'sum' => $sum]);
      }
      
    public function indexAll() {
      $sells = Purchase::orderBy('created_at')->get();
      $sum = $sells->sum('total_price');
      
      return view('/admin/purchase/index', ['sells' => $sells, 'sum' => $sum]);
    }

    public function purchasePost(PurchasePost $request) {

      // バリデート
      $start_date = $request->start_date;
      $last_date = $request->last_date;
      
      //セッションにスタート、ラストを保存
      $request->session()->put('start_date', $start_date);
      $request->session()->put('last_date', $last_date);

      $sells = Purchase::whereBetween('created_at', [$start_date, $last_date])->orderBy('created_at')->get();
      $sum = $sells->sum('total_price');

      return view('/admin/purchase/index', ['sells' => $sells, 'sum' => $sum]);
    }

    public function detail(Request $request, $id) {
      // 販売履歴をすべて表示か期間表示かに分けるため、直前のURLを取得
      $url = parse_url(url()->previous(), PHP_URL_PATH);
      $path = str_replace('/ecsite3/public/admin/purchase/', '', $url);
      
      $details = Purchasedetail::where('purchase_id', $id)->get();
      $items = Item::withTrashed()->select('id', 'name', 'price')->get();
      $sum = $details->sum('total_price');
      return view('/admin/purchase/detail', [
        'details' =>$details,
        'items' => $items,
        'sum' => $sum,
        'path' => $path,
      ]);
    }
}
