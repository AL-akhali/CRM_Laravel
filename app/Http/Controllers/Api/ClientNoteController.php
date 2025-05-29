<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientNote;
use Illuminate\Http\Request;
use App\Http\Resources\ClientNoteResource;

class ClientNoteController extends Controller
{
    public function index()
    {
        return ClientNoteResource::collection(ClientNote::with('user')->get());
    }

    public function show(ClientNote $clientNote)
    {
        return new ClientNoteResource($clientNote->load('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'content'    => 'required|string',
            'visibility' => 'required|in:private,public',
        ]);

        $note = ClientNote::create($data);

        return new ClientNoteResource($note->load('user'));
    }

    public function update(Request $request, ClientNote $clientNote)
    {
        $data = $request->validate([
            'content'    => 'sometimes|required|string',
            'visibility' => 'sometimes|required|in:private,public',
        ]);

        $clientNote->update($data);

        return new ClientNoteResource($clientNote->load('user'));
    }

    public function destroy(ClientNote $clientNote)
    {
        $clientNote->delete();

        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}
