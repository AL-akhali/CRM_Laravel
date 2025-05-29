<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientContact;
use Illuminate\Http\Request;
use App\Http\Resources\ClientContactResource;

class ClientContactController extends Controller
{
    public function index()
    {
        return ClientContactResource::collection(ClientContact::all());
    }

    public function show(ClientContact $clientContact)
    {
        return new ClientContactResource($clientContact);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email',
            'phone'     => 'nullable|string',
            'position'  => 'nullable|string|max:255',
        ]);

        $contact = ClientContact::create($data);

        return new ClientContactResource($contact);
    }

    public function update(Request $request, ClientContact $clientContact)
    {
        $data = $request->validate([
            'name'      => 'sometimes|required|string|max:255',
            'email'     => 'nullable|email',
            'phone'     => 'nullable|string',
            'position'  => 'nullable|string|max:255',
        ]);

        $clientContact->update($data);

        return new ClientContactResource($clientContact);
    }

    public function destroy(ClientContact $clientContact)
    {
        $clientContact->delete();

        return response()->json(['message' => 'Deleted'], 204);
    }
}
