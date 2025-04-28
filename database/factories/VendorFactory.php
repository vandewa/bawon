<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_perusahaan' => $this->faker->company,
            'nib' => $this->faker->unique()->numerify('#############'),
            'npwp' => $this->faker->optional()->numerify('##.###.###.#-###.###'),
            'alamat' => $this->faker->address,
            'email' => $this->faker->companyEmail,
            'telepon' => $this->faker->phoneNumber,
            'nama_direktur' => $this->faker->name,
            'jenis_usaha' => $this->faker->randomElement(['Konstruksi', 'Pengadaan Barang', 'Konsultan']),
            'klasifikasi' => $this->faker->word,
            'kualifikasi' => $this->faker->randomElement(['Kecil', 'Menengah', 'Besar']),
            'provinsi' => $this->faker->state,
            'kabupaten' => $this->faker->city,
            'kode_pos' => $this->faker->postcode,

            'akta_pendirian' => 'akta_dummy.pdf',
            'nib_file' => 'nib_dummy.pdf',
            'npwp_file' => 'npwp_dummy.pdf',
            'siup' => 'siup_dummy.pdf',
            'izin_usaha_lain' => 'izin_lain_dummy.pdf',
            'ktp_direktur' => 'ktp_dummy.jpg',
            'rekening_perusahaan' => 'rekening_dummy.pdf',
        ];
    }
}
