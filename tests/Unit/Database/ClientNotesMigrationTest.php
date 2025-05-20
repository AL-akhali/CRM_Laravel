<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientNotesMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_notes_table_exists()
    {
        $this->assertTrue(Schema::hasTable('client_notes'));
    }

    /** @test */
    public function client_notes_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('client_notes', [
            'id',
            'client_id',
            'user_id',
            'content',
            'visibility',
            'created_at',
            'updated_at'
        ]));
    }
}
