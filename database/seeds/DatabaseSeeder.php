<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 先に読み込み
        // $this->call(UsersTableSeeder::class);
        // $this->call(PurchasedetailsTableSeeder::class);
        // $this->call(ItemsTableSeeder::class);
        // 後に読み込み
        $this->call(PurchaseTableSeeder::class);
    }
}
