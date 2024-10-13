<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [ 'name' => '黒ボールペン','code'=>'P001','price'=>201,'tax'=>10 ],
            [ 'name' => '赤ボールペン','code'=>'P002','price'=>202,'tax'=>10 ],
            [ 'name' => '青ボールペン','code'=>'P003','price'=>203,'tax'=>10 ],
            [ 'name' => '緑ボールペン','code'=>'P004','price'=>204,'tax'=>10 ],
            [ 'name' => '紫ボールペン','code'=>'P005','price'=>205,'tax'=>10 ],
            [ 'name' => '黒シャープペン','code'=>'P006','price'=>206,'tax'=>10 ],
            [ 'name' => '赤シャープペン','code'=>'P007','price'=>207,'tax'=>10 ],
            [ 'name' => '青シャープペン','code'=>'P008','price'=>208,'tax'=>10 ],
            [ 'name' => '緑シャープペン','code'=>'P009','price'=>209,'tax'=>10 ],
            [ 'name' => '紫シャープペン','code'=>'P010','price'=>210,'tax'=>10 ],
            [ 'name' => 'メロンパン','code'=>'F001','price'=>180,'tax'=>8 ],
            [ 'name' => 'アンパン','code'=>'F002','price'=>200,'tax'=>8 ],
        ];
        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'code' => $product['code'],
                'price' => $product['price'],
                'Tax' => $product['tax'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
