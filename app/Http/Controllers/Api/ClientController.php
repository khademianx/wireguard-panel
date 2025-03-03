<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateWireguardClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => ['nullable', 'string']]);

        $query = Client::latest('id');

        if ($request->has('q') && $request->q !== '') {
            $query->where('username', 'like', '%'.$request->q.'%');
        }

        return ClientResource::collection($query->paginate(perPage: 100));
    }

    public function store(ClientStoreRequest $request, CreateWireguardClient $action)
    {
        $client = $action->handle($request->validated());

        if ($request->expectsJson()) {
            return response(new ClientResource($client), Response::HTTP_CREATED);
        }

        return \response()->redirectToRoute('dashboard');
    }

    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->update($request->validated());

        if ($request->expectsJson()) {
            return response(new ClientResource($client));
        }

        return redirect(route('dashboard'));
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json();
    }
}
