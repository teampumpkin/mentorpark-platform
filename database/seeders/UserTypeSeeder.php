<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'name' => 'Mentor',
                'slug' => 'mentor',
            ],
            [
                'name' => 'Mentee',
                'slug' => 'mentee',
            ],
            [
                'name' => 'Coach',
                'slug' => 'coach',
            ],
        ];

        foreach ($userTypes as $type) {
            UserType::create($type);
        }
    }
}
