<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientActivity;
use Illuminate\Http\Request;
use App\Http\Resources\ClientActivityResource;

class ClientActivityController extends Controller
{
    public function index()
    {
        return ClientActivityResource::collection(ClientActivity::all());
    }

    public function show(ClientActivity $clientActivity)
    {
        return new ClientActivityResource($clientActivity);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'type'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $activity = ClientActivity::create($data);

        return new ClientActivityResource($activity);
    }

    public function update(Request $request, ClientActivity $clientActivity)
    {
        $data = $request->validate([
            'type'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $clientActivity->update($data);

        return new ClientActivityResource($clientActivity);
    }

    public function destroy(ClientActivity $clientActivity)
    {
        $clientActivity->delete();

        return response()->json(['message' => 'Deleted'], 204);
    }
}
