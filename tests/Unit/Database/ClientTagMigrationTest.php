<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientTagMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_tags_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_tags'));
    }

    public function test_client_tags_table_has_expected_columns(): void
    {
        $expected = [
            'id',
            'name',
            'slug',
            'color',
            'created_at',
            'updated_at',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('client_tags', $column),
                "Missing column: $column"
            );
        }
    }
    public function test_name_and_slug_are_unique(): void
{
    \DB::table('client_tags')->insert([
        'name' => 'VIP',
        'slug' => 'vip',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    \DB::table('client_tags')->insert([
        'name' => 'VIP',  // مكرر
        'slug' => 'vip',  // مكرر
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

}
