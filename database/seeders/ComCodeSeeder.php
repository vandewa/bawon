<?php

namespace Database\Seeders;

use App\Models\ComCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('com_codes')->truncate();

        $data = [

            ['com_cd' => 'TPK_TYPE_01', 'code_nm' => 'Ketua', 'code_group' => 'TPK_TYPE'],
            ['com_cd' => 'TPK_TYPE_02', 'code_nm' => 'Sekretaris', 'code_group' => 'TPK_TYPE'],
            ['com_cd' => 'TPK_TYPE_03', 'code_nm' => 'Anggota', 'code_group' => 'TPK_TYPE'],


        ];

        foreach ($data as $item) {
            ComCode::create($item);
        }
    }
}
