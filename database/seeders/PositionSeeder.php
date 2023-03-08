<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Entities\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::transaction(function () {
        //     Position::factory(10)->create();
        //     DB::commit();
        // });

        DB::table('position')->insert([
            [
                'name' => '總店長',
            ],
            [
                'name' => '主任',
            ],
            [
                'name' => '店長',
            ],
            [
                'name' => '客服人員',
            ],
            [
                'name' => '美編人員',
            ],
            [
                'name' => '副店長',
            ],
            [
                'name' => '副組長',
            ],
            [
                'name' => '專員',
            ],
            [
                'name' => '專業銷售員',
            ],
            [
                'name' => '組長',
            ],
            [
                'name' => '會計專員',
            ],
            [
                'name' => '管理專員',
            ],
            [
                'name' => '職員',
            ],
        ]);
    }
}
