<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bank')->index();
            $table->uuid('debit_id')->unique();
            $table->uuid('account_from_id');
            $table->uuid('account_to_id');
            $table->unsignedDouble('value');
            $table->string('kind');
            $table->string('key');
            $table->string('description');
            $table->string('status');
            $table->string('cancel_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
