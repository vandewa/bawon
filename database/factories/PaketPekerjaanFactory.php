<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaketPekerjaan>
 */
class PaketPekerjaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tahun' => $this->faker->numberBetween(2023, 2025),
            'kd_keg' => $this->faker->regexify('[A-Z0-9]{6}'),
            'sumberdana' => $this->faker->randomElement(['APBD', 'Dana Desa', 'Banprov']),
            'nama_kegiatan' => $this->faker->sentence(3),
            'nilaipak' => $this->faker->numberBetween(10000000, 500000000),
            'satuan' => $this->faker->randomElement(['Paket', 'Unit']),
            'pagu_pak' => $this->faker->numberBetween(10000000, 500000000),
            'nm_pptkd' => $this->faker->name(),
            'jbt_pptkd' => $this->faker->jobTitle(),
            'nama_bidang' => $this->faker->word(),
            'nama_subbidang' => $this->faker->word(),
            'kegiatan_st' => $this->faker->randomElement(['KEGIATAN_ST_01', 'KEGIATAN_ST_02']),
        ];
    }
}
