<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->truncate();
        DB::table('categories')->insert(
            [
                [
                    'name' => 'Cryptocurrency',
                ],
                [
                    'name' => 'NFTs',
                ],
                [
                    'name' => 'Blockchain',
                ],
                [
                    'name' => 'Code',
                ],
                [
                    'name' => 'Services',
                ],
                [
                    'name' => 'Hardware',
                ],
            ]
        );
    }
}
