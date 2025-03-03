<?php

namespace App\Listeners;

use App\Events\ClientDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class DeleteWireguardPeerListener implements ShouldQueue
{
    public function handle(ClientDeletedEvent $event): void
    {
        Artisan::call('wireguard:config');
    }
}
