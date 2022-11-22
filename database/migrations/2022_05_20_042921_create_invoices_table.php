<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stakeholder_id');
            $table->foreignId('user_id')->constrained()
                                        ->onDelete('restrict')
                                        ->onUpdate('cascade');
             $table->foreignId('currency_id')->constrained()
                                             ->onDelete('cascade')
                                             ->onUpdate('cascade')
                                             ;
            $table->enum('payment_terms',['DUE_ON_RECEIPT','NET_TEN','NET_TWENTY','NET_THIRTY','SET_MANUALLY']);
            $table->string('remarks',191);
            $table->softDeletes();
            $table->date('date');
            $table->date('due_date');
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
        Schema::dropIfExists('invoices');
    }
}
