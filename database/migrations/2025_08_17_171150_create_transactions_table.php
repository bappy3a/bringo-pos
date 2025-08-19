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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('business_locations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type',['opening_stock','sell','purchase']);
            $table->enum('status',['open','closed'])->default('open');
            $table->enum('payment_status',['pending','due','paid'])->default('pending');
            $table->string('payment_method')->default('cash');
            $table->string('invoice_no')->nullable();
            $table->dateTime('transaction_date');
            $table->double('amount')->default(0);
            $table->double('discount')->default(0);
            $table->double('due')->default(0);
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
