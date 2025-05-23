<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['payable', 'receivable']);
            $table->date('date');
            $table->text('note')->nullable();
            $table->timestamps();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
