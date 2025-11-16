<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInformation; // Make sure you have this model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        UserInformation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::create([
            'first_name' => 'Satyam',
            'last_name' => 'Maurya',
            'name' => 'Satyam Maurya',
            'email' => 'satyam.maurya@teampumpkin.com',
            'password' => Hash::make('Satyam@123'),
            'email_verified_at' => now(),
        ]);

        UserInformation::create([
            'user_id' => $user->id,
            'user_type' => ['Mentor', 'Coach'],
            'about' => 'A passionate software developer with extensive experience in the Laravel ecosystem, dedicated to building robust and scalable web applications.',
            'job_title' => 'Senior Laravel Developer',
            'total_experience' => '5 Years',
            'skills' => ['PHP', 'Laravel', 'Livewire', 'Vue.js', 'MySQL', 'Docker'],
            'goal' => 'To mentor upcoming developers and contribute to innovative open-source projects.',
            'linkedin' => 'https://www.linkedin.com/in/satyammaurya-example',
            'twitter' => 'https://twitter.com/satyammaurya-example',
            'website' => 'https://satyammaurya-example.com',
            'country' => 'India',
            'state' => 'Maharashtra',
        ]);
    }
}
