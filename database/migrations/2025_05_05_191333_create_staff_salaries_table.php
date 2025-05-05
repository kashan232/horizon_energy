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
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('remarks')->nullable();
            $table->string('staff_month'); // Format: YYYY-MM
            $table->date('staff_date')->nullable();
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('status')->nullable(); // Example: 'paid', 'partial'
            $table->string('month')->nullable(); // Optional if staff_month is used
            $table->decimal('advance_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key (if staff table exists)
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salaries');
    }
};
