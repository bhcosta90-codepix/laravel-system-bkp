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
        Schema::create('pix_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bank');
            $table->foreignUuid('account_id')->on('accounts');
            $table->string('kind');
            $table->string('key');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->unique(['kind', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pix_keys');
    }
};
