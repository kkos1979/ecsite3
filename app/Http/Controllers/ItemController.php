<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; //DBファサードの使用
use App\Http\Requests\ItemsCreatePost; // フォームリクエストによるバリデーション
use \App\Item;

class ItemController extends Controller
{
    //
    public function index() {
      $items = Item::all();
      return view('/admin/items/index', ['items' => $items]);
    }

    // 確認画面用
    public function confirmIndex() {
      $items = Item::all();
      return view('index', ['items' => $items]);
    }

    public function editGet($id) {
      $g = Item::where('id', '=', $id)->first();
      return view('/admin/items/edit', ['g' => $g]);
    }

    public function editPost(ItemsCreatePost $request, $id) {

      // DBの更新
      $now = \Carbon\Carbon::now();
      Item::where('id', '=', $id)->update([
        'name' => $request->items_name,
        'comment' => $request->comment,
        'price' => $request->price,
        'stock' => $request->stock,
        'updated_at' => $now,
      ]);
      return redirect()->action('ItemController@index');
    }

    public function uploadGet($id, $name) {
      return view('/admin/items/upload', ['id' => $id, 'name' => $name]);
    }

    public function uploadPost(Request $request, $id) {
      // バリデート
      $rules = [
        'pic' => ['required', 'file', 'image', 'mimes:jpeg', 'max:2048'],
      ];
      $this->validate($request, $rules);

      $pic = $request->file('pic');

      //intervention Imageで加工
      // composer require intervention/image)
      // ->config/app.phpのprovidersに追加 [ Intervention\Image\ImageServiceProvider::class, ]
      // ->config/app.phpのaliasesに追加   [ 'Image' => Intervention\Image\Facades\Image::class, ]
      // public/imagesフォルダへ保存

      $img = \Image::make($pic)->resize(100, 100)->save(public_path() . '/images/' . $id . '.jpg');
      //DBに画像情報を追加
      $now = \Carbon\Carbon::now();
      Item::where('id', '=', $id)->update([
        'image' => $id,
        'updated_at' => $now,
      ]);

      return redirect()->action('ItemController@index');
    }

    public function destroy($id) {
      Item::where('id', $id)->delete();
      return redirect()->action('ItemController@index');
    }

    public function create() {
      return view('admin.items.create');
    }

    public function store(ItemsCreatePost $request) {

      // DBの更新
      $now = \Carbon\Carbon::now();
      Item::insert([
        'name' => $request->items_name,
        'comment' => $request->comment,
        'price' => $request->price,
        'stock' => $request->stock,
        'created_at' => $now,
        'updated_at' => $now,
      ]);
      return redirect()->action('ItemController@index');
    }
}
