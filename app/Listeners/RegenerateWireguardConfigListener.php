<?php

namespace App\Listeners;

use App\Events\ClientUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class RegenerateWireguardConfigListener implements ShouldQueue
{
    public function handle(ClientUpdatedEvent $event): void
    {
        Artisan::call('wireguard:config');
    }
}
