<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory(10)->create()->each(function ($employee) {
            $certificationIds = Certification::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $employee->certifications()->attach($certificationIds);
        });
    }
}
