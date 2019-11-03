<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Item;
use \App\Purchase;
use \App\Purchasedetail;
use \App\Purchase_chart;
use App\Http\Requests\PurchasePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //DBファサードの使用

class PurchaseController extends Controller
{
    //
    public function purchasePost(PurchasePost $request) {

      $years = [];
      $models = Purchase::all();
      foreach ($models as $model) {
        $years[] = $model->created_at->format('Y');
      }
      $start_year = min($years);
      $last_year = max($years);

      // バリデート
      $start_date = $request->start_date;
      $last_date = $request->last_date;

      //セッションにスタート、ラストを保存
      $request->session()->put('start_date', $start_date);
      $request->session()->put('last_date', $last_date);

      $sells = Purchase::whereBetween('created_at', [$start_date, $last_date])->orderBy('created_at')->get();
      $sum = $sells->sum('total_price');

      // 選択期間表示用データ
      $start_priod_year = substr($start_date, 0, 4);
      $start_priod_month = substr($start_date, 5, 2);
      $last_priod_year = substr($last_date, 0, 4);
      $last_priod_month = substr($last_date, 5, 2);

      // chart.js用データの作成
      $start_date = substr($start_date, 0, 7);
      $last_date = substr($last_date, 0, 7);

      // 共通：年月データの格納
      $labels = [];
      // 月別売上高
      $salesData = [];
      $data = Purchase_chart::withTrashed()->whereBetween('date', [$start_date, $last_date])->orderBy('date')->get();
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
      $data = Purchasedetail::withTrashed()
        ->whereBetween('date', [$start_date, $last_date])
        ->select('item_id', 'date')->orderBy('date')->get();
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

      return view('/admin/purchase/index', [
        'sells' => $sells,
        'sum' => $sum,
        'start_year' => $start_year,
        'last_year' => $last_year,
        'start_priod_year' => $start_priod_year,
        'start_priod_month' => $start_priod_month,
        'last_priod_year' => $last_priod_year,
        'last_priod_month' => $last_priod_month,
        'labels' => $labels,
        'salesData' => $salesData,
        'itemsChartData' => $itemsChartData,
        'start_date' => $start_date,
        'last_date' => $last_date,
      ]);
    }

    public function purchaseGet(Request $request) {

      $years = [];
      $models = Purchase::all();
      foreach ($models as $model) {
        $years[] = $model->created_at->format('Y');
      }
      $start_year = min($years);
      $last_year = max($years);

      //セッションからスタート、ラストを取得
      $start_date = $request->session()->get('start_date');
      $last_date = $request->session()->get('last_date');

      $sells = Purchase::whereBetween('created_at', [$start_date, $last_date])->orderBy('created_at')->get();
      $sum = $sells->sum('total_price');

      // 選択期間表示用データ
      $start_priod_year = substr($start_date, 0, 4);
      $start_priod_month = substr($start_date, 5, 2);
      $last_priod_year = substr($last_date, 0, 4);
      $last_priod_month = substr($last_date, 5, 2);

      // chart.js用データの作成
      $start_date = substr($start_date, 0, 7);
      $last_date = substr($last_date, 0, 7);

      // 共通：年月データの格納
      $labels = [];
      // 月別売上高
      $salesData = [];
      $data = Purchase_chart::withTrashed()->whereBetween('date', [$start_date, $last_date])->orderBy('date')->get();
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
      $data = Purchasedetail::withTrashed()
        ->whereBetween('date', [$start_date, $last_date])
        ->select('item_id', 'date')->orderBy('date')->get();
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

      return view('/admin/purchase/index', [
        'sells' => $sells,
        'sum' => $sum,
        'start_year' => $start_year,
        'last_year' => $last_year,
        'start_priod_year' => $start_priod_year,
        'start_priod_month' => $start_priod_month,
        'last_priod_year' => $last_priod_year,
        'last_priod_month' => $last_priod_month,
        'labels' => $labels,
        'salesData' => $salesData,
        'itemsChartData' => $itemsChartData,
        'start_date' => $start_date,
        'last_date' => $last_date,
      ]);
    }

    public function detail(Request $request, $id) {
      // 販売履歴をすべて表示か期間表示かに分けるため、直前のURLを取得
      $url = parse_url(url()->previous(), PHP_URL_PATH);
      // $path = str_replace('/ecsite3/public/admin/purchase/', '', $url);
      $path = str_replace('/admin/', '', $url);

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
