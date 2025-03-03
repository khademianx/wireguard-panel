<?php

namespace App\Listeners;

use App\Events\ClientCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class CreateWireguardPeerListener implements ShouldQueue
{
    public function handle(ClientCreatedEvent $event): void
    {
        Artisan::call('wireguard:config');
    }
}
