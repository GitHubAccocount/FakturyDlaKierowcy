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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('company');
            $table->string('street');
            $table->unsignedInteger('main_number');
            $table->unsignedInteger('local_number');
            $table->string('city');
            $table->unsignedInteger('postal_code_1');
            $table->unsignedInteger('postal_code_2');
            $table->unsignedInteger('nip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
