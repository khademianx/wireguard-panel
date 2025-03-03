<?php

namespace App\Console\Commands;

use Dotenv\Dotenv;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

class SetupCommand extends Command
{
    protected $signature = 'setup';

    protected $description = 'Setup Application';

    public function handle(): void
    {
        $hasDomain = confirm(
            label: 'Do you have a domain?',
            default: false,
        );

        if ($hasDomain) {
            $domain = text(
                label: 'What is your domain?',
                required: true,
                validate: ['domain' => 'regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i']
            );

            $generateCertificate = confirm(
                label: 'Get SSL certificate for domain?',
                default: false,
            );
        } else {
            $domain = text(
                label: 'Enter dashboard IP address?',
                default: $_SERVER['SERVER_ADDR'] ?? '',
                required: true,
                validate: ['domain' => 'ip']
            );
        }

        /* $port = text(
            label: 'Enter dashboard port',
            default: isset($generateCertificate) && $generateCertificate ? 443 : 80,
            required: true,
            validate: ['port' => 'between:1,65535']
        ); */

        $wireguardAddress = text(
            label: 'Enter Wireguard server address',
            default: $domain,
            required: true,
            validate: ['wireguardAddress' => 'string']
        );

        $wireguardPort = text(
            label: 'Enter Wireguard port',
            default: 51820,
            required: true,
            validate: ['port' => 'between:1,65535']
        );

        $scheme = (isset($generateCertificate) && $generateCertificate) ? 'https://' : 'http://';

        $envContent = Dotenv::parse(file_get_contents(base_path('.env')));
        $envContent['APP_URL'] = $scheme.$domain;

        if (isset($generateCertificate) && $generateCertificate) {
            $envContent['APP_DOMAIN'] = $domain;
            $envContent['USE_HTTPS'] = true;
            $envContent['SUPERVISOR_PHP_COMMAND'] = '"php artisan octane:start --https --admin-port=2019"';
        } else {
            unset($envContent['SUPERVISOR_PHP_COMMAND']);
            unset($envContent['APP_DOMAIN']);
            unset($envContent['USE_HTTPS']);
        }

        $envContent['WIREGUARD_ADDRESS'] = $wireguardAddress;
        $envContent['WIREGUARD_PORT'] = $wireguardPort;

        $newContent = '';

        foreach ($envContent as $key => $value) {
            $newContent .= $key.'='.$value.PHP_EOL;
        }

        $put = file_put_contents(base_path('.env'), $newContent);

        if (! $put) {
            $this->error('Can not edit .env file!');

            return;
        }

        $this->info('Done.');
        $this->info('Your dashboard domain is: '.$scheme.$domain);
    }
}
