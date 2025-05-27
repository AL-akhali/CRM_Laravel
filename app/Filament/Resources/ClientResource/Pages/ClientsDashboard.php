<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ClientResource;
use App\Models\Client;
use App\Models\ClientTag;

class ClientsDashboard extends ListRecords
{
    protected static string $resource = ClientResource::class;
    protected static string $view = 'filament.resources.client-resource.pages.clients-dashboard';

    public $newClientData = [
        'name' => '',
        'type' => '',
        'email' => '',
        'phone' => '',
        'industry' => '',
        'address' => '',
        'status' => '',
        'tags' => [],
    ];

    public $clients;
    public $selectedClient = null;
    public $editClientData = [];
    public $availableTags = [];
    public $editMode = false;

    public function mount(): void
{
    $this->clients = Client::with('contacts', 'tags')->latest()->take(10)->get();
    $this->availableTags = ClientTag::all();
}


    public function createClient()
    {
        $validated = validator($this->newClientData, [
            'name' => 'required|unique:clients,name',
            'type' => 'required',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required',
            'industry' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'status' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:client_tags,id',
        ])->validate();

        $client = Client::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'industry' => $this->newClientData['industry'] ?? null,
            'address' => $this->newClientData['address'] ?? null,
            'status' => $validated['status'],
        ]);

        if (!empty($validated['tags'])) {
            $client->tags()->sync($validated['tags']);
        }

        $this->newClientData = [
            'name' => '',
            'type' => '',
            'email' => '',
            'phone' => '',
            'industry' => '',
            'address' => '',
            'status' => '',
            'tags' => [],
        ];

        $this->clients->prepend($client);
        $this->selectedClient = $client;
        $this->editMode = false;
        session()->flash('success', 'تم إضافة العميل بنجاح.');
    }

    public function selectClient($id)
    {
        $this->selectedClient = Client::with('tags')->find($id);
        $this->editClientData = $this->selectedClient->toArray();
        // tags علاقة خاصة لذلك تحتاج صياغة خاصة:
        $this->editClientData['tags'] = $this->selectedClient->tags->pluck('id')->toArray();
        $this->editMode = false;
    }

    public function enableEdit()
    {
        if ($this->selectedClient) {
            $this->editMode = true;
        }
    }

    public function updateClient()
    {
        if (!$this->selectedClient) {
            session()->flash('error', 'لم يتم اختيار عميل.');
            return;
        }

        $validated = validator($this->editClientData, [
            'name' => 'required|unique:clients,name,' . $this->selectedClient->id,
            'type' => 'required',
            'email' => 'required|email|unique:clients,email,' . $this->selectedClient->id,
            'phone' => 'required',
            'industry' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'status' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:client_tags,id',
        ])->validate();

        $this->selectedClient->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'industry' => $this->editClientData['industry'] ?? null,
            'address' => $this->editClientData['address'] ?? null,
            'status' => $validated['status'],
        ]);

        $this->selectedClient->tags()->sync($validated['tags'] ?? []);

        $this->clients = Client::latest()->take(10)->get(); // تحديث القائمة

        $this->editMode = false;
        session()->flash('success', 'تم تحديث بيانات العميل.');
    }

    public function deleteClient()
    {
        if (!$this->selectedClient) {
            session()->flash('error', 'لم يتم اختيار عميل.');
            return;
        }

        $this->selectedClient->delete();

        $this->clients = Client::latest()->take(10)->get(); // تحديث القائمة
        $this->selectedClient = null;
        $this->editMode = false;
        session()->flash('success', 'تم حذف العميل بنجاح.');
    }
}
