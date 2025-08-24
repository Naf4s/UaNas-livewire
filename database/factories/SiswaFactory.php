<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'siswa'])->id,
            'nis' => $this->faker->unique()->numerify('2024###'),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nama_lengkap' => $this->faker->name(),
            'nama_panggilan' => $this->faker->firstName(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-12 years', '-6 years')->format('Y-m-d'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'alamat' => $this->faker->streetAddress(),
            'rt_rw' => $this->faker->numerify('###/###'),
            'desa_kelurahan' => $this->faker->city(),
            'kecamatan' => $this->faker->city(),
            'kabupaten_kota' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'kode_pos' => $this->faker->postcode(),
            'no_hp' => $this->faker->numerify('08##########'),
            'nama_ayah' => $this->faker->name('male'),
            'pekerjaan_ayah' => $this->faker->jobTitle(),
            'no_hp_ayah' => $this->faker->numerify('08##########'),
            'nama_ibu' => $this->faker->name('female'),
            'pekerjaan_ibu' => $this->faker->jobTitle(),
            'no_hp_ibu' => $this->faker->numerify('08##########'),
            'alamat_ortu' => $this->faker->address(),
            'nama_wali' => null,
            'pekerjaan_wali' => null,
            'no_hp_wali' => null,
            'alamat_wali' => null,
            'status_siswa' => 'aktif',
            'tanggal_masuk' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'tanggal_keluar' => null,
            'keterangan' => null,
        ];
    }

    /**
     * Indicate that the student is male.
     */
    public function male(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'L',
        ]);
    }

    /**
     * Indicate that the student is female.
     */
    public function female(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'P',
        ]);
    }

    /**
     * Indicate that the student is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_siswa' => 'aktif',
        ]);
    }

    /**
     * Indicate that the student is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_siswa' => 'nonaktif',
        ]);
    }

    /**
     * Indicate that the student has graduated.
     */
    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_siswa' => 'lulus',
            'tanggal_keluar' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the student has transferred.
     */
    public function transferred(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_siswa' => 'pindah',
            'tanggal_keluar' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the student has left.
     */
    public function left(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_siswa' => 'keluar',
            'tanggal_keluar' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ]);
    }
}
