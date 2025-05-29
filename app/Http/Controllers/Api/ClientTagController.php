<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientTag;
use Illuminate\Http\Request;
use App\Http\Resources\ClientTagResource;

class ClientTagController extends Controller
{
    public function index()
    {
        return ClientTagResource::collection(ClientTag::all());
    }

    public function show(ClientTag $clientTag)
    {
        return new ClientTagResource($clientTag);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255|unique:client_tags,name',
            'color' => 'nullable|string|max:7', // مثل #FF0000
        ]);

        $tag = ClientTag::create($data);

        return new ClientTagResource($tag);
    }

    public function update(Request $request, ClientTag $clientTag)
    {
        $data = $request->validate([
            'name'  => 'sometimes|required|string|max:255|unique:client_tags,name,' . $clientTag->id,
            'color' => 'nullable|string|max:7',
        ]);

        $clientTag->update($data);

        return new ClientTagResource($clientTag);
    }

    public function destroy(ClientTag $clientTag)
    {
        $clientTag->delete();

        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}
