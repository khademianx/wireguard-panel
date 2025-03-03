<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Foundation\Events\Dispatchable;

class ClientCreatedEvent
{
    use Dispatchable;

    public function __construct(public Client $client) {}
}
