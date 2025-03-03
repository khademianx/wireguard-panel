<?php

namespace App\Actions;

use App\Enums\ClientStatus;
use App\Models\Client;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Random\RandomException;

class CreateWireguardClient
{
    /**
     * @throws RandomException
     */
    public function handle(array $data): Client
    {
        $privateKey = $this->generatePrivateKey();
        $publicKey = $this->generatePublicKey($privateKey);
        $address = $this->generateIp();

        return Client::create([
            'hash' => sha1(Str::random(32)),
            'username' => $data['username'],
            'address' => $address.'/32',
            'private_key' => $privateKey,
            'public_key' => $publicKey,
            'status' => ClientStatus::Enable,
            'expire_at' => $data['expire_at'],
        ]);
    }

    /**
     * @throws RandomException
     */
    protected function generateIp(): string
    {
        $first = random_int(1, 255);
        $second = random_int(0, 255);
        $last = random_int(0, 255);
        $ip = "10.{$first}.{$second}.{$last}";

        if (Client::query()->where('address', $ip)->exists()) {
            $ip = $this->generateIp();
        }

        return $ip;
    }

    protected function generatePrivateKey(): string
    {
        if (app()->runningUnitTests()) {
            return 'test';
        }

        $result = Process::timeout(10)->run('wg genkey');

        abort_unless($result->successful(), 500, "Can't create wireguard private key");

        return trim($result->output());
    }

    protected function generatePublicKey(string $privateKey): string
    {
        if (app()->runningUnitTests()) {
            return 'test';
        }

        $command = "echo \"$privateKey\" | wg pubkey";
        $result = Process::timeout(10)->run($command);

        abort_unless($result->successful(), 500, "Can't create wireguard public key");

        return trim($result->output());
    }
}
