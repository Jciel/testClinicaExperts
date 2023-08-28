<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_accesses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('ip')->nullable(false);
            $table->dateTime('date')->nullable(false);
            $table->string('country')->nullable(false);
            $table->string('continent')->nullable(false);
            $table->string('region')->nullable(false);
            $table->string('city')->nullable(false);
            $table->string('userAgent')->nullable(false);
            $table->string('identifierUrl')->nullable(false);

            $table->foreignUuid('short_link_id')->references('id')->on('short_links')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_accesses');
    }
};
