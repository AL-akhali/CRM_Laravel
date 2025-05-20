<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientNotesMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_client_notes_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_notes'));
    }

    /** @test */
    public function it_checks_client_notes_table_has_expected_columns(): void
    {
        $columns = [
            'id',
            'client_id',
            'user_id',
            'content',
            'visibility',
            'created_at',
            'updated_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('client_notes', $column),
                "Missing column: $column"
            );
        }
    }
}
