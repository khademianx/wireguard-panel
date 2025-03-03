<?php

namespace App\Jobs;

use App\Enums\ClientStatus;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class CheckClientsForExpireJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $clients = Client::query()
            ->where('status', ClientStatus::Enable)
            ->where('expire_at', '<=', now())
            ->get();

        if ($clients->isNotEmpty()) {
            foreach ($clients as $client) {
                $client->status = ClientStatus::Disable;
                $client->save();
            }

            Artisan::call('wireguard:config');
        }
    }
}
