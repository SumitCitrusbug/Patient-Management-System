<?php

namespace Database\Seeders;

use App\Models\Docter;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Docter::factory()->count(20)->create();

        DB::table('docters')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'hadiyal nilkanth',
                'email' => 'hadiaynilkanth@gmail.com',
                'specialties' => 'Anesthesiologist',
                'amount' => 100,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'lakum sumit',
                'email' => 'sumit123@gmail.com',
                'specialties' => 'Cardiologist',
                'amount' => 300,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'lakum amit',
                'email' => 'amit123@gmail.com',
                'specialties' => 'Geneticist',
                'amount' => 500,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'satani raj',
                'email' => 'raj123@gmail.com',
                'specialties' => 'Nephrologist',
                'amount' => 90,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'chavda japu',
                'email' => 'japu123@gmail.com',
                'specialties' => 'Surgeon',
                'amount' => 130,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'shah ayus',
                'email' => 'ayus123@gmail.com',
                'specialties' => 'Anesthesiologist',
                'amount' => 150,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'amit makvana',
                'email' => 'amit0123@gmail.com',
                'specialties' => 'Orthopedist',
                'amount' => 300,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'hadiyal sures',
                'email' => 'sures123@gmail.com',
                'specialties' => 'Nephrologist',
                'amount' => 200,
            ],
        ]);
    }
}
