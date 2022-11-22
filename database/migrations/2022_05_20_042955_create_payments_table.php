<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
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
            $table->string('control_number',191);
            $table->foreignId('currency_id')->constrained()
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->string('payee',191);
            $table->string('remarks',191);
            $table->string('reference',191);
            $table->foreignId('user_id')->constrained()
                                        ->onDelete('restrict')
                                        ->onUpdate('cascade');
            $table->softDeletes();
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
}
