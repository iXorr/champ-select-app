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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();
            $table->string('address');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->enum('payment_method', ['cash', 'card']);
            $table->enum('status', ['new', 'in_progress', 'done', 'canceled'])->default('new')->index();
            $table->text('cancellation_reason')->nullable();
            $table->unsignedInteger('total_price');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
