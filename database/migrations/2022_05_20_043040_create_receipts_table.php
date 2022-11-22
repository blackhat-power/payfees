<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('reference',191);
            $table->foreignId('currency_id')->constrained()
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->string('remarks',191);
            $table->string('control_number',191);
            $table->string('payer',191);
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
        Schema::dropIfExists('receipts');
    }
}
