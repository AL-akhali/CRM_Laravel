<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ClientContactMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_client_contacts_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('client_contacts'));
    }

    /** @test */
    public function it_checks_client_contacts_table_has_expected_columns(): void
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

    /** @test */
    public function it_ensures_email_is_unique_per_client(): void
    {
        $client = Client::factory()->create();

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'Contact One',
            'email' => 'test@example.com',
        ]);

        $this->expectException(QueryException::class);

        ClientContact::create([
            'client_id' => $client->id,
            'name' => 'Contact Two',
            'email' => 'test@example.com',
        ]);
    }
}
