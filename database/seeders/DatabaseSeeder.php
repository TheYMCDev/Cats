<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();
         \App\Models\Cat::factory(10)->create();
         \App\Models\Vaccine::factory(10)->create();
         \App\Models\VaccineCat::factory(10)->create();
    }
}
