[Interface]
Address = {{ str($client->address)->replace('/32', '/24') }}
PrivateKey = {{ $client->private_key }}
DNS = 8.8.8.8, 4.2.2.4

[Peer]
PublicKey = {{ $publicKey }}
AllowedIPs = 0.0.0.0/0, ::/0
Endpoint = {{ config('wireguard.address') }}:{{ config('wireguard.port') }}
PersistentKeepalive = 25
