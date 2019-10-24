<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
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

        DB::table('items')->insert([
          'name' => 'うどん',
          'comment' => 'コシのあるうどん',
          'price' => 500,
          'stock' => 30,
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        DB::table('items')->insert([
          'name' => 'そば',
          'comment' => 'そば粉100％',
          'price' => 400,
          'stock' => 20,
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        DB::table('items')->insert([
          'name' => 'パスタ',
          'comment' => 'トマトソースたっぷり',
          'price' => 300,
          'stock' => 25,
          'created_at' => $now,
          'updated_at' => $now,
        ]);//
        $now = \Carbon\Carbon::now();

        DB::table('items')->insert([
          'name' => '麺つゆ',
          'comment' => '出汁がきいています',
          'price' => 200,
          'stock' => 30,
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        DB::table('items')->insert([
          'name' => 'ミートソース',
          'comment' => '当社オリジナル製品',
          'price' => 100,
          'stock' => 20,
          'created_at' => $now,
          'updated_at' => $now,
        ]);
    }
}
