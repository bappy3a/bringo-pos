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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('business_locations')->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->double('amount')->default(0);
            $table->double('paid')->default(0);
            $table->double('due')->default(0);
            $table->double('discount')->default(0);
            $table->double('tax')->default(0);
            $table->double('total')->default(0);
            $table->enum('payment_status',['paid','due']);
            $table->string('payment_method')->nullable();
            $table->string('reference_no')->nullable();
            $table->tinyText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
