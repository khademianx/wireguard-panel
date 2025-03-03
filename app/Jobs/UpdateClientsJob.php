<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Process;

class UpdateClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $result = Process::run(['wg', 'show', 'wg0', 'dump']);

        abort_unless($result->successful(), 500, $result->errorOutput());

        $collect = str($result->output())
            ->trim()
            ->explode("\n")
            ->collect()
            ->splice(1)
            ->map(function ($item) {
                [$publicKey, $preSharedKey, $endpoint, $allowedIps, $latestHandshake, $outbound, $inbound, $persistentKeepalive] = explode("\t", $item);

                return collect([
                    'publicKey' => trim($publicKey),
                    'preSharedKey' => trim($preSharedKey),
                    'endpoint' => $endpoint,
                    'allowedIps' => $allowedIps,
                    'latestHandshake' => $latestHandshake,
                    'inbound' => $inbound,
                    'outbound' => $outbound,
                    'persistentKeepalive' => $persistentKeepalive,
                ]);
            });

        $collect->each(function ($item) {
            $client = Client::query()->where(['public_key' => $item['publicKey']])->first();

            if ($client) {
                $client->update([
                    'last_handshake' => $item['latestHandshake'] ? Carbon::createFromTimestamp($item['latestHandshake']) : null,
                    'inbound' => $item['inbound'],
                    'outbound' => $item['outbound'],
                ]);
            }
        });
    }
}
