<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Entities\Code;
use App\Models\Entities\Codes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $test = Code::factory()->makeOne();


        Code::factory(5)->create();

    }
}
