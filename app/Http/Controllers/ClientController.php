<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function create()
    {
        return Inertia::render('client/CreateClient');
    }

    public function edit(Client $client)
    {
        return Inertia::render('client/EditClient', ['client' => $client]);
    }
}
