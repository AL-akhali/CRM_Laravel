<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;;

class ClientMigrationTest extends TestCase
{
     use RefreshDatabase;

    public function test_clients_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('clients'));
    }

    public function test_clients_table_has_expected_columns(): void
    {
        $expected = [
            'id',
            'name',
            'type',
            'email',
            'phone',
            'industry',
            'address',
            'status',
            'created_at',
            'updated_at',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('clients', $column),
                "Missing column: $column"
            );
        }
    }
}

