<?php

namespace App\Models;

use App\Enums\ClientStatus;
//use App\Events\ClientCreatedEvent;
//use App\Events\ClientDeletedEvent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_handshake' => 'datetime',
        'expire_at' => 'datetime',
        'status' => ClientStatus::class,
    ];

    protected $dispatchesEvents = [
//        'created' => ClientCreatedEvent::class,
//        'deleted' => ClientDeletedEvent::class,
    ];

    public function qrContent(): Attribute
    {
        return Attribute::make(
            get: fn () => view('wireguard.client', ['client' => $this, 'publicKey' => Storage::get('wireguard/publicKey')])->render(),
        );
    }
}
