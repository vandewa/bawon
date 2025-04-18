<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Desa>
 */
class DesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kabupaten' => 'Wonosobo',
            'kode_desa' => $this->faker->unique()->numerify('33.07.##.####'),
            'kecamatan_id' => $this->faker->numerify('33.07.##'),
            'name' => $this->faker->unique()->city(),
            'kode_pos' => $this->faker->postcode(),
            'alamat' => $this->faker->address(),
            'web' => $this->faker->domainName(),
            'email' => $this->faker->unique()->safeEmail(),
            'telp' => $this->faker->phoneNumber(),
        ];
    }
}
