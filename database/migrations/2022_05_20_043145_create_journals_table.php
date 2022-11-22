<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('type',
            ['SALES','CASH PAYMENT','PURCHASES',
            'CASH RECEIPT','PURCHASES RETURN',
            'SALES RETURN','JOURNAL']
            );
            $table->string('remarks',191);
            $table->string('relationable_type',191);
            $table->bigInteger('relationable_id');
            $table->date('date');
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
        Schema::dropIfExists('journals');
    }
}
