<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('case_types')->insert([
            'name' => 'PARNIČNI'
        ]);

        DB::table('case_types')->insert([
            'name' => 'KRIVIČNI'
        ]);

        DB::table('case_types')->insert([
            'name' => 'PREKRŠAJNI'
        ]);

        DB::table('case_types')->insert([
            'name' => 'IZVRŠNI'
        ]);

        DB::table('case_types')->insert([
            'name' => 'VANSUDSKI'
        ]);

        DB::table('case_types')->insert([
            'name' => 'OSTALO'
        ]);
    }
}
