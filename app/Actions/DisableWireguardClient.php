<?php

namespace App\Actions;

use App\Enums\ClientStatus;
use App\Events\ClientUpdatedEvent;
use App\Models\Client;

class DisableWireguardClient
{
    public function handle(Client $client): void
    {
        $client->status = ClientStatus::Disable;

        $client->save();

        event(new ClientUpdatedEvent($client));
    }
}
