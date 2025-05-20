<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientContactMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_contacts_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_contacts'));
    }

    public function test_client_contacts_table_has_expected_columns(): void
    {
        $expected = [
            'id',
            'client_id',
            'name',
            'email',
            'phone',
            'position',
            'created_at',
            'updated_at',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('client_contacts', $column),
                "Missing column: $column"
            );
        }
    }
    public function test_email_must_be_unique_per_client(): void
{
    $client = \App\Models\Client::factory()->create();

    \App\Models\ClientContact::create([
        'client_id' => $client->id,
        'name' => 'Contact One',
        'email' => 'test@example.com',
    ]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    \App\Models\ClientContact::create([
        'client_id' => $client->id,
        'name' => 'Contact Two',
        'email' => 'test@example.com',
    ]);
}

}
