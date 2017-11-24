<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'users';
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $senha = Hash::make('123456');
        $users = [
            ['name'=>'Saulo Gomes','email'=>'saulobr88@gmail.com','password'=>$senha,'created_at'=> $now,'updated_at' => $now],
            ['name'=>'Ikaro Alef','email'=>'ikaroalef@gmail.com','password'=>$senha,'created_at'=> $now,'updated_at' => $now],
            ['name'=>'Fulano da silva','email'=>'fulano@gmail.com','password'=>$senha,'created_at'=> $now,'updated_at' => $now],
            ['name'=>'Beltrano Rodrigues','email'=>'beltrano@gmail.com','password'=>$senha,'created_at'=> $now,'updated_at' => $now],
            ['name'=>'Sicrano Moura','email'=>'sicrano@gmail.com','password'=>$senha,'created_at'=> $now,'updated_at' => $now],
        ];
        DB::table($table)->insert($users);
    }
}
