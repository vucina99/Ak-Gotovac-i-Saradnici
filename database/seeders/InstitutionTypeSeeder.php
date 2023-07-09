<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institution_types')->insert([
            'name' => 'SUD'
        ]);

        DB::table('institution_types')->insert([
            'name' => 'TUŽILAŠTVO'
        ]);

        DB::table('institution_types')->insert([
            'name' => 'IZVRŠITELJ'
        ]);

        DB::table('institution_types')->insert([
            'name' => 'OSIGURANJE'
        ]);

        DB::table('institution_types')->insert([
            'name' => 'JAVNI BELEŽNIK'
        ]);
    }
}
