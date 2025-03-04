<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name"=> "mobile",
            "price"=> 50000,
            "desc"=> "iphone 15",
            "quantity"=> 2,
        ]);

        Product::create([
            "name"=> "mobile",
            "price"=> 30000,
            "desc"=> "iphone 13",
            "quantity"=> 4,
        ]);

        Product::create([
            "name"=> "mobile",
            "price"=> 40000,
            "desc"=> "iphone 14",
            "quantity"=> 5,
        ]);

        Product::create([
            "name"=> "mobile",
            "price"=> 60000,
            "desc"=> "iphone 16",
            "quantity"=> 5,
        ]);
    }
}
