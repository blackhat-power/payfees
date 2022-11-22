<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->enum('terms',['Annually','Semi Annually','Monthly','Quarterly']);
            $table->foreignId('user_id')->constrained()
                                        ->onDelete('restrict')
                                        ->onUpdate('cascade');
            $table->string('contractable_type',191);
            $table->bigInteger('contractable_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('contracts');
    }
}
