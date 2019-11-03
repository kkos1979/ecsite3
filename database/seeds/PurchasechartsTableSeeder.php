<?php

use Illuminate\Database\Seeder;
use \App\Purchase;
use \App\Purchasecart;

class PurchasechartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //
      $now = \Carbon\Carbon::now();
      $faker = Faker\Factory::create('ja_JP');

      $purchases = Purchase::all();
      $dates = [];

      foreach ($purchases as $purchase) {
        $key = substr($purchase->created_at, 0, 7);
        if (!isset($dates[$key])) {
          $dates[$key] = 0;
        }
        $dates[$key] += $purchase->total_price;
      }

      foreach ($dates as $key => $value) {
        $data = [
          'sales' => $value,
          'date' => $key,
          'created_at' => $now,
          'updated_at' => $now,
        ];
        DB::table('purchase_charts')->insert($data);
      }
    }
}
