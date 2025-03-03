<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->string('username');
            $table->string('address');
            $table->string('private_key');
            $table->string('public_key');
            $table->boolean('status');
            $table->bigInteger('inbound')->default(0);
            $table->bigInteger('outbound')->default(0);
            $table->dateTime('last_handshake')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
