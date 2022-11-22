<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')
                            ->constrained()
                            ->onDelete('cascade')
                            ->onUpdate('cascade');
            $table->double('quantity');
            $table->double('rate');
            $table->foreignId('tax_id')->constrained()
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->string('descriptions',191);
            $table->double('exchange_rate');
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
        Schema::dropIfExists('payment_items');
    }
}
