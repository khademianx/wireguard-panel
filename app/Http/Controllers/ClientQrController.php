<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientQrController extends Controller
{
    public function __invoke(Client $client)
    {
        return view('qr', ['client' => $client]);
    }
}
