<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_documented_users(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'name' => 'Administrador',
            'email' => 'admin@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Enzo Martins',
            'email' => 'enzoea256@gmail.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Leonardo Pai',
            'email' => 'leonardo.pai@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Bianca Scoralick',
            'email' => 'bianca.scoralick@example.com',
        ]);
    }
}
