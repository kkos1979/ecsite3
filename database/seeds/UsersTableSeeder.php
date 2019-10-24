<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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

        DB::table('users')->insert([
          'name' => '管理者',
          'address' => '東京都',
          'email' => 'admin@example.com',
          'tel' => '0312345678',
          'password' => Hash::make('asd'),
          'role' => 'admin',
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        // ゲスト用
        DB::table('users')->insert([
          'name' => 'ゲスト',
          'address' => '東京都',
          'email' => 'guest@example.com',
          'tel' => '0312345678',
          'password' => Hash::make('asd'),
          'role' => 'customer',
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        // テストユーザー
        DB::table('users')->insert([
          'name' => 'テストユーザー',
          'address' => '東京都',
          'email' => 'test@example.com',
          'tel' => '0312345678',
          'password' => Hash::make('asd'),
          'role' => 'customer',
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        for ($i = 0; $i < 10; $i++) {
          $user = [
            'name' => $faker->name,
            'address' => $faker->address,
            'email' => $faker->email,
            'tel' => $faker->phoneNumber,
            'password' => Hash::make('asd'),
            'role' => 'customer',
            'created_at' => $now,
            'updated_at' => $now,
          ];
          DB::table('users')->insert($user);
        }
    }
}
