<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'tags';
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            ['name'=>'baixo custo','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
            ['name'=>'rápido','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
            ['name'=>'paisagens','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
            ['name'=>'litoral','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
            ['name'=>'histórico','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
            ['name'=>'topzera','user_id'=>'1','created_at'=> $now,'updated_at' => $now],
        ];
        DB::table($table)->insert($data);
    }
}
