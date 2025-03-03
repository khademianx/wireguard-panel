<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ClientController extends Controller
{
    public function create()
    {
        return Inertia::render('client/CreateClient');
    }
}
