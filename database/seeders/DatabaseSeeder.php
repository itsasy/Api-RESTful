<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Desactivar llaves foraneas
        //DB::statement('SET FOREIGN_KEY_CHECKS=0'); //Desactivar llaves foraneas para Mysql
        DB::statement('PRAGMA foreign_keys = 0'); //Desactivar llaves foraneas para sqlite

        //Borrar datos
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        //Borrar contenido de tabla pivot
        DB::table('category_product')->truncate();


        $usersQuantity = 100;
        $categoriesQuantity = 30;
        $productsQuantity = 100;
        $transactionsQuantity = 100;

        User::factory($usersQuantity)->create();

        Category::factory($categoriesQuantity)->create();

        Product::factory($productsQuantity)->create()->each(
        /* Asosación de muchos a muchos */
            function ($product) {
                //Agregando las categorías de forma aleatoria
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

                $product->categories()->attach($categories);
            }
        );

        Transaction::factory($transactionsQuantity)->create();
    }
}
