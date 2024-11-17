<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            'Project Management Professional (PMP)',
            'Certified Scrum Master (CSM)',
            'Cisco Certified Network Associate (CCNA)',
            'Certified Information Systems Security Professional (CISSP)',
            'AWS Certified Solutions Architect',
        ];

        foreach ($certifications as $certificationName) {
            Certification::create(['name' => $certificationName]);
        }
    }
}
