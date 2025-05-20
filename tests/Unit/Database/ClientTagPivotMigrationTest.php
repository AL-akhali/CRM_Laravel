<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientTagPivotMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_tag_pivot_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_tags'));
    }

    public function test_client_tag_pivot_table_has_expected_columns(): void
    {
        $expected = [
            'client_id',
            'client_tag_id',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('client_client_tag', $column),
                "Missing column: $column"
            );
        }
    }

    public function test_client_tag_pivot_table_has_unique_constraint(): void
    {
        $client = \App\Models\Client::factory()->create();
        $tag = \App\Models\ClientTag::factory()->create();

        \DB::table('client_client_tag')->insert([
            'client_id' => $client->id,
            'client_tag_id' => $tag->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // محاولة تكرار نفس العلاقة
        \DB::table('client_client_tag')->insert([
            'client_id' => $client->id,
            'client_tag_id' => $tag->id,
        ]);
    }
}
