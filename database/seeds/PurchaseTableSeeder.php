<?php

use Illuminate\Database\Seeder;
use \App\Purchasedetail;

class PurchaseTableSeeder extends Seeder
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

      for ($i = 1; $i <= 20; $i++) {

        $total_price = Purchasedetail::where('purchase_id', $i)->sum('total_price');
        $purchase = [
          'total_price' => $total_price,
          'user_id' => $faker->numberBetween(2, 12),
          'created_at' => $faker->dateTimeThisYear,
          'updated_at' => $now,
        ];
        DB::table('purchases')->insert($purchase);
      }
    }
}
