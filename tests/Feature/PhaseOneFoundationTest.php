<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PhaseOneFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_has_cher_journal_homepage(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_foundation_tables_are_present(): void
    {
        $expectedTables = [
            'roles',
            'role_user',
            'categories',
            'emotions',
            'settings',
            'user_profiles',
            'user_settings',
        ];

        foreach ($expectedTables as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Table [$table] should exist."
            );
        }
    }
}
