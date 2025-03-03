<?php

use App\Jobs\CheckClientsForExpireJob;
use App\Jobs\UpdateClientsJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new UpdateClientsJob)->everyFiveSeconds();
Schedule::job(new CheckClientsForExpireJob)->everyFiveMinutes();
