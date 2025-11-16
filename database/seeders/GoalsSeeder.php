<?php

namespace Database\Seeders;

use App\Models\Master\Goal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            'Become financially independent',
            'Travel to new countries',
            'Improve physical fitness',
            'Develop healthy habits',
            'Build strong relationships with family and friends',
            'Start a business',
            'Learn a new language',
            'Read more books',
            'Reduce stress and improve mental health',
            'Become a better communicator',
            'Give back to the community',
            'Complete a personal project',
            'Learn to cook',
            'Achieve work-life balance',
            'Volunteer for a cause'
        ];

        // Insert skills into the database
        foreach ($goals as $goal) {
            Goal::create([
                'name' => $goal
            ]);
        }
    }
}
