# Server
[Interface]
Address = {{ $address }}
PrivateKey = {{ $privateKey }}
ListenPort = {{ $port }}
PostUp = {{ $postUp }}
PostDown= {{ $postDown }}
DNS = 1.1.1.1

@foreach($clients as $client)
# Client: {{ $client->username }}
[Peer]
PublicKey = {{ $client->public_key }}
AllowedIPs = {{ $client->address }}
PersistentKeepalive = 25

@endforeach
