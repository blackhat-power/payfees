<?php

use Brick\Math\BigInteger;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id')
                    ->constrained()
                    ->onDelete('cascade')
                    ->onUpdate('cascade')
                    ->nullable();
            $table->double('quantity');
            $table->double('rate');
            $table->foreignId('tax_id')
                            ->constrained()
                            ->onDelete('cascade')
                            ->onUpdate('cascade');
            $table->double('exchange_rate');
            $table->string('descriptions',191);
            $table->foreignId('invoice_id')
                            ->constrained()
                            ->onDelete('cascade')
                            ->onUpdate('cascade');
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
        Schema::dropIfExists('invoice_items');
    }
}
