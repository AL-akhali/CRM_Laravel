<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Filament\Resources\ClientResource\Pages\CreateClient;


class ClientResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_client()
    {
        Livewire::test(CreateClient::class)
            ->fillForm([
                'name' => 'شركة التقنية',
                'type' => 'شركة',
                'email' => 'tech@example.com',
                'phone' => '778888999',
                'industry' => 'برمجيات',
                'address' => 'الحديدة',
                'status' => 'فعال',
            ])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'name' => 'شركة التقنية',
        ]);
    }
}
