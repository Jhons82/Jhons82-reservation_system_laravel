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
        Schema::create('reservations_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->string('transaction_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_email')->nullable(); //Email del pagador
            $table->string('payment_status')->nullable(); //Estado del pagador
            $table->decimal('amout', 10 ,2)->nullable();
            $table->text('response_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations_details');
    }
};
