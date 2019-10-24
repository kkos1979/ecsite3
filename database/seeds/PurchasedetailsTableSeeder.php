<?php

use Illuminate\Database\Seeder;

class PurchasedetailsTableSeeder extends Seeder
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

        for ($i = 0; $i < 40; $i++) {

          $item_id = $faker->numberBetween(1, 5);
          $quantity = $faker->numberBetween(1, 10);
          switch($item_id) {
            case 1:
              $price = 500;
              break;
            case 2:
              $price = 400;
              break;
            case 3:
              $price = 300;
              break;
            case 4:
              $price = 200;
              break;
            default:
              $price = 100;
              break;
          }
          $price = $price * $quantity;

          $purchasedetail = [
            'purchase_id' => $faker->numberBetween(1, 20),
            'item_id' => $item_id,
            'price' => $price,
            'quantity' => $quantity,
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $now,
          ];
          DB::table('purchasedetails')->insert($purchasedetail);
        }
    }
}
