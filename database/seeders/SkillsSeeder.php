<?php

namespace Database\Seeders;

use App\Models\Master\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Leadership',
            'Communication',
            'Time Management',
            'Problem Solving',
            'Teamwork',
            'Adaptability',
            'Creativity',
            'Critical Thinking',
            'Emotional Intelligence',
            'Decision Making',
            'Conflict Resolution',
            'Project Management',
            'Negotiation',
            'Public Speaking',
            'Active Listening'
        ];

        // Insert skills into the database
        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
