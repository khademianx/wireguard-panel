<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Client */
class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hash' => $this->hash,
            'address' => $this->address,
            'username' => $this->username,
            'inbound' => $this->inbound,
            'outbound' => $this->outbound,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'last_handshake' => $this->last_handshake?->diffForHumans(),
            'expire_at' => $this->expire_at?->diffForHumans(),
            'is_online' => isset($this->last_handshake) && $this->last_handshake->gt(now()->subMinute()),

            'download_url' => route('download', $this->hash),
            'qr_url' => route('qr', $this->hash),
            'qr_content' => $this->qr_content,
        ];
    }
}
