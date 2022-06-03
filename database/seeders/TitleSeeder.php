<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('titles')->truncate();
        DB::table('titles')->insert(
            [
                [
                    'name' => 'Artist'
                ],
                [
                    'name' => 'Developer'
                ],
                [
                    'name' => 'Musician'
                ],
                [
                    'name' => 'Investor'
                ],
                [
                    'name' => 'Gamer'
                ],
            ]
        );
    }
}
