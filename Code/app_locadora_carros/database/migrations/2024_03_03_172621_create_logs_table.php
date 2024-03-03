<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->string('user_id')->nullable()->comment('If the user is authenticated, store the user ID. Otherwise, store null.');
            $table->string('user_name')->comment('If the user is authenticated, store the user name. Otherwise, store "anonymous".');
            $table->string('ip');
            $table->longText('user_agent');
            $table->string('method');
            $table->string('route');
            $table->string('status');
            $table->string('response_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
