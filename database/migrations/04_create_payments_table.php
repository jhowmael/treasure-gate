<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('mercado_pago_payment_id', 255);
            $table->string('external_reference'); // ID da compra
            $table->string('payer_email', 255)->nullable();
            $table->string('payer_number', 255)->nullable();
            $table->decimal('total_value', 10, 2);
            $table->string('method', 255)->nullable();
            $table->string('type', 255);
            $table->dateTime('registered')->nullable();
            $table->dateTime('approved');
            $table->dateTime('deined');
            $table->enum('status', ['pending', 'registered', 'approved', 'deined', 'error']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
