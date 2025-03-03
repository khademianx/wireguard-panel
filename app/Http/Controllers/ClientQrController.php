<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientQrController extends Controller
{
    public function __invoke(Client $client)
    {
        return inertia('client/ClientQr', [
            'client' => $client,
            'qr_content' => $client->qr_content,
        ]);
    }
}
