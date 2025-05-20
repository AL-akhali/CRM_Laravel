<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientActivitiesMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_client_activities_table_exists()
    {
        $this->assertTrue(
            Schema::hasTable('client_activities'),
            'The client_activities table does not exist.'
        );
    }

    /** @test */
    public function it_checks_client_activities_table_has_required_columns()
    {
        $expectedColumns = [
            'id',
            'client_id',
            'type',
            'description',
            'created_at',
            'updated_at',
        ];

        foreach ($expectedColumns as $column) {
            $this->assertTrue(
                Schema::hasColumn('client_activities', $column),
                "Missing column: $column"
            );
        }
    }
}
