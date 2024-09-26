<?php

namespace Database\Seeders;

use App\Models\Admin\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Team 1'],
            ['name' => 'Team 2'],
        ];

        foreach ($teams as $team)
        {
            Team::create($team);
        }
    }
}
