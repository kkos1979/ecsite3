<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Item;
use \App\Purchase;
use \App\Purchasedetail;
use App\Http\Requests\PurchasePost;
use Illuminate\Support\Facades\DB; //DBファサードの使用

class PurchaseController extends Controller
{
    //
    public function index() {
      $sells = Purchase::orderBy('created_at')->get();
      $sum = $sells->sum('total_price');

      return view('/admin/purchase/index', ['sells' => $sells, 'sum' => $sum]);
    }

    public function purchasePost(PurchasePost $request) {

      // バリデート
      $start_date = $request->start_date;
      $last_date = $request->last_date;

      $sells = Purchase::whereBetween('created_at', [$start_date, $last_date])->orderBy('created_at')->get();
      $sum = $sells->sum('total_price');

      return view('/admin/purchase/index', ['sells' => $sells, 'sum' => $sum]);
    }

    public function detail($id) {
      $details = Purchasedetail::where('purchase_id', $id)->get();
      $items = Item::withTrashed()->select('id', 'name', 'price')->get();
      $sum = $details->sum('price');
      return view('/admin/purchase/detail', [
        'details' =>$details,
        'items' => $items,
        'sum' => $sum,
      ]);
    }
}
