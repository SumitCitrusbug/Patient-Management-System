<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Doctor;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $doctor = Doctor::all('id');

        DB::table('timeslots')->insert([
            [

                'id' => Str::uuid(),
                'doctor_id' => $doctor[0]->id,
                'date' => '2024-01-01',
                'time_start' => '3:00:00',
                'time_end' => '5:00:00',

            ],
            [

                'id' => Str::uuid(),
                'doctor_id' => $doctor[0]->id,
                'date' => '2024-01-02',
                'time_start' => '4:00:00',
                'time_end' => '5:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' =>  $doctor[1]->id,
                'date' => '2024-02-01',
                'time_start' => '14:00:00',
                'time_end' => '18:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' =>  $doctor[1]->id,
                'date' => '2024-03-01',
                'time_start' => '17:00:00',
                'time_end' => '18:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' =>  $doctor[2]->id,
                'date' => '2024-01-03',
                'time_start' => '8:00:00',
                'time_end' => '10:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[2]->id,
                'date' => '2024-03-01',
                'time_start' => '09:00:00',
                'time_end' => '11:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[3]->id,
                'date' => '2024-04-01',
                'time_start' => '8:00:00',
                'time_end' => '12:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[3]->id,
                'date' => '2024-01-02',
                'time_start' => '8:00:00',
                'time_end' => '10:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[4]->id,
                'date' => '2024-02-01',
                'time_start' => '8:00:00',
                'time_end' => '10:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[4]->id,
                'date' => '2024-02-04',
                'time_start' => '9:00:00',
                'time_end' => '10:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[5]->id,
                'date' => '2024-03-08',
                'time_start' => '15:00:00',
                'time_end' => '19:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[5]->id,
                'date' => '2024-03-09',
                'time_start' => '17:00:00',
                'time_end' => '18:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[6]->id,
                'date' => '2024-4-11',
                'time_start' => '07:00:00',
                'time_end' => '09:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[6]->id,
                'date' => '2024-5-11',
                'time_start' => '08:00:00',
                'time_end' => '10:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[7]->id,
                'date' => '2024-02-06',
                'time_start' => '10:00:00',
                'time_end' => '12:00:00',

            ],
            [
                'id' => Str::uuid(),
                'doctor_id' => $doctor[7]->id,
                'date' => '2024-09-02',
                'time_start' => '13:00:00',
                'time_end' => '14:00:00',

            ],
        ]);
    }
}
