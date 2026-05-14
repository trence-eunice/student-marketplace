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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->string('reference_number')->unique();
        $table->decimal('amount', 10, 2);
        $table->enum('method', ['gcash', 'cash_on_delivery', 'bank_transfer'])->default('cash_on_delivery');
        $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('payments');
}
};
