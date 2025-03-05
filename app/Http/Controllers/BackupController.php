<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function create()
    {
        $json = Client::query()->get()->toJson();

        Storage::put('backup.json', $json);

        $backup = Storage::path('backup.json');

        return response()->download($backup);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json'],
        ]);

        $json = json_decode(file_get_contents($request->file->getRealPath()), true);

        foreach ($json as $client) {
            if (! Client::where('username', $client['username'])->where('hash', $client['hash'])->exists()) {
                unset($client['id']);
                Client::createQuietly($client);
            }
        }

        return redirect()->route('dashboard');
    }
}
