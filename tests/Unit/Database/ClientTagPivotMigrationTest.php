<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientTagPivotMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_client_tag_pivot_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_client_tag'));
    }

    /** @test */
    public function it_checks_client_tag_pivot_table_has_expected_columns(): void
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

    /** @test */
    public function it_enforces_unique_constraint_on_client_tag_pivot_table(): void
    {
        $client = \App\Models\Client::factory()->create();
        $tag = \App\Models\ClientTag::factory()->create();

        \DB::table('client_client_tag')->insert([
            'client_id' => $client->id,
            'client_tag_id' => $tag->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        \DB::table('client_client_tag')->insert([
            'client_id' => $client->id,
            'client_tag_id' => $tag->id,
        ]);
    }
}
