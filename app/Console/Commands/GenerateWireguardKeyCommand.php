<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class GenerateWireguardKeyCommand extends Command
{
    protected $signature = 'wireguard:key';

    protected $description = 'Generate Wireguard keys';

    public function handle(): void
    {
        if (
            Storage::exists('wireguard/privateKey') &&
            Storage::exists('wireguard/publicKey')
        ) {
            $this->comment('Wireguard key already exists.');

            Artisan::call('wireguard:config');

            exit(0);
        }

        $privateKey = $this->generatePrivateKey();

        $this->generatePublicKey($privateKey);

        Artisan::call('wireguard:config');
    }

    public function generatePrivateKey(): string
    {
        $result = Process::run('wg genkey');

        if (! $result->successful()) {
            $this->error("Can't create wireguard private key -> ".$result->errorOutput());

            exit(1);
        }

        Storage::put('wireguard/privateKey', trim($result->output()));

        $this->info('Private key: '.$result->output());

        return $result->output();
    }

    public function generatePublicKey(string $privateKey): string
    {
        $command = "echo \"$privateKey\" | wg pubkey";
        $result = Process::run($command);

        if (! $result->successful()) {
            $this->error("Can't create wireguard public key -> ".$result->errorOutput());

            exit(1);
        }

        Storage::put('wireguard/publicKey', trim($result->output()));

        $this->info('Public key: '.$result->output());

        return $result->output();
    }
}
