<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Purchase;
use \App\Purchase_chart;
use \App\Purchasedetail;
use \App\Item;

class AdminController extends Controller
{

    public function index() {

      $years = [];
      $models = Purchase::all();
      foreach ($models as $model) {
        $years[] = $model->created_at->format('Y');
      }
      $start_year = min($years);
      $last_year = max($years);

      $sells = Purchase::orderBy('created_at')->paginate(15);
      $t_sells = Purchase::orderBy('created_at')->get();
      $sum = $t_sells->sum('total_price');

      // chart.js用データの作成
      // 共通：年月データの格納
      $labels = [];
      // 月別売上高
      $salesData = [];
      $data = Purchase_chart::withTrashed()->orderBy('date')->get();
      foreach ($data as $d) {
        $labels[] = $d->date;
        $salesData[] = $d->sales;
      }
      $labels = json_encode($labels);
      $salesData = json_encode($salesData);

      // 商品別販売数
      // 商品詳細テーブルから販売年月と商品IDを取得
      $date = [];
      $items_id = [];
      $data = Purchasedetail::withTrashed()->select('item_id', 'date')->orderBy('date')->get();
      foreach ($data as $d) {
        $date[] = $d->date;
        $items_id[] = $d->item_id;
      }
      // 販売年月と商品IDの重複削除、並べ替え
      $date = array_unique($date);
      $items_id = array_unique($items_id);
      sort($items_id);

      // chart.jsのデータに合わせて加工
      // 商品IDごとに各月の販売数量を登録
      $itemsData = [];
      foreach ($date as $d) {
        foreach ($items_id as $item_id) {
          if (!isset($itemsData[$item_id])) {
            $itemsData[$item_id] = [];
          }
          // 対象月に売り上げがある場合
          if (Purchasedetail::withTrashed()->where([['date', $d], ['item_id', $item_id]])->exists()) {
            $purchases = Purchasedetail::withTrashed()->select('quantity')->where([['date', $d], ['item_id', $item_id]])->get();
            $itemsSum = $purchases->sum('quantity');
            $itemsData[$item_id][] = $itemsSum;
          // 対象月に売り上げがない場合
          } else {
            $itemsData[$item_id][] = 0;
          }
        }
      }

      // 商品IDを商品名に変更
      $itemsChartData = [];
      foreach ($itemsData as $key => $value) {
        $item = Item::find($key);
        $name = $item->name;
        $itemsChartData[$name] = $value;
      }
      $itemsChartData = json_encode($itemsChartData, JSON_UNESCAPED_UNICODE);

      return view('/admin/index', [
        'start_year' => $start_year,
        'last_year' => $last_year,
        'sells' => $sells,
        'sum' => $sum,
        'labels' => $labels,
        'salesData' => $salesData,
        'itemsChartData' => $itemsChartData
      ]);
    }

}
