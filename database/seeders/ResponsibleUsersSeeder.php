<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ResponsibleUsersSeeder extends Seeder
{
    /**
     * Seed the default responsible users documented for the project.
     */
    public function run(): void
    {
        $responsibleUsers = [
            [
                'name' => 'Enzo Martins',
                'email' => 'enzoea256@gmail.com',
            ],
            [
                'name' => 'Leonardo Pai',
                'email' => 'leonardo.pai@example.com',
            ],
            [
                'name' => 'Bianca Scoralick',
                'email' => 'bianca.scoralick@example.com',
            ],
        ];

        foreach ($responsibleUsers as $responsibleUser) {
            User::updateOrCreate(
                ['email' => $responsibleUser['email']],
                [
                    'name' => $responsibleUser['name'],
                    'password' => '123456',
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
