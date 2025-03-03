<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class DownloadConfigController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function __invoke(Client $client)
    {
        $config = view('wireguard.client', [
            'client' => $client,
            'publicKey' => Storage::get('wireguard/publicKey'),
        ])->render();

        Storage::disk('public')->put('configs/'.$client->hash.'.conf', $config);

        defer(function () use ($client) {
            Storage::disk('public')->delete('configs/'.$client->hash.'.conf');
        });

        return response()
            ->download(
                Storage::disk('public')->path('configs/'.$client->hash.'.conf'),
                $client->username.'.conf'
            );
    }
}
