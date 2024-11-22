<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'title' => 'Contributor',
                'icon' => 'icons/contributor.png',
                'description' => 'Awarded for contributing to the project.',
            ],
            [
                'title' => 'Early Adopter',
                'icon' => 'icons/early_adopter.png',
                'description' => 'Awarded to the first users of the platform.',
            ],
            [
                'title' => 'Top Performer',
                'icon' => 'icons/top_performer.png',
                'description' => 'Awarded for outstanding performance.',
            ],
            [
                'title' => 'Team Player',
                'icon' => 'icons/team_player.png',
                'description' => 'Awarded for exceptional collaboration.',
            ],
        ];

        #Todo: think about how to save the icons
        /*foreach ($badges as $badge) {
            Badge::create($badge);
        }*/

        $this->command->info('Badges seeded successfully!');
    }
}
