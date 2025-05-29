<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    public function index()
    {
        return ClientResource::collection(Client::with(['contacts', 'notes', 'activities', 'tags'])->get());
    }

    public function show(Client $client)
    {
        return new ClientResource($client->load(['contacts', 'notes', 'activities', 'tags']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string',
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string',
            'industry' => 'nullable|string',
            'address'  => 'nullable|string',
            'status'   => 'required|string',
        ]);

        $client = Client::create($data);

        return new ClientResource($client);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'type'     => 'sometimes|required|string',
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string',
            'industry' => 'nullable|string',
            'address'  => 'nullable|string',
            'status'   => 'sometimes|required|string',
        ]);

        $client->update($data);

        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Deleted'], 204);
    }
}
