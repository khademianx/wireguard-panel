<?php

namespace App\Console\Commands;

use App\Enums\ClientStatus;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class GenerateWireguardConfigCommand extends Command
{
    protected $signature = 'wireguard:config';

    protected $description = 'Generate Wireguard Config file';

    /**
     * @throws \Throwable
     */
    public function handle(): void
    {
        if (
            ! Storage::exists('wireguard/privateKey') ||
            ! Storage::exists('wireguard/publicKey')
        ) {
            $this->error('Wireguard keys not exists, run php artisan wireguard:key');

            exit(0);
        }

        $privateKey = Storage::get('wireguard/privateKey');
        $publicKey = Storage::get('wireguard/publicKey');
        $address = '10.8.0.1/24';
        $port = 51820;

        $postUp = 'iptables -t nat -A POSTROUTING -s 10.0.0.0/8 -o eth0 -j MASQUERADE; iptables -A INPUT -p udp -m udp --dport 51820 -j ACCEPT; iptables -A FORWARD -i wg0 -j ACCEPT; iptables -A FORWARD -o wg0 -j ACCEPT;';
        $postDown = 'iptables -t nat -D POSTROUTING -s 10.0.0.0/8 -o eth0 -j MASQUERADE; iptables -D INPUT -p udp -m udp --dport 51820 -j ACCEPT; iptables -D FORWARD -i wg0 -j ACCEPT; iptables -D FORWARD -o wg0 -j ACCEPT;';

        $config = view('wireguard.config', [
            'privateKey' => $privateKey,
            'publicKey' => $publicKey,
            'address' => $address,
            'port' => $port,
            'postUp' => $postUp,
            'postDown' => $postDown,
            'clients' => Client::query()
                ->where('status', ClientStatus::Enable)
                ->where(function (Builder $query) {
                    $query->whereNull('expire_at')
                        ->orWhere('expire_at', '>', now());
                })
                ->get(),
        ])->render();

        Storage::put('wireguard/wg0.conf', $config);

        $configPath = Storage::path('wireguard/wg0.conf');

        $move = Process::run("mv $configPath ".'/etc/wireguard/wg0.conf');

        abort_unless($move->successful(), 500, $move->errorOutput());

        Process::run(['wg-quick', 'down', 'wg0']);

        $up = Process::run(['wg-quick', 'up', 'wg0']);

        abort_unless($up->successful(), 500, $up->errorOutput());

        $this->info('Done.');
    }
}
