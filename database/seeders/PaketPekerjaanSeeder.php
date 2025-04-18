<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketPekerjaan;
use App\Models\Desa;

class PaketPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desas = Desa::all();

        foreach ($desas as $desa) {
            PaketPekerjaan::factory()->count(5)->create([
                'desa_id' => $desa->id,
                'kd_desa' => $desa->kode_desa,
            ]);
        }
    }
}
