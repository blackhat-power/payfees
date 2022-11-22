<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_detail_seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->enum('status',['active','deactive']);
            $table->foreignId('account_school_details_id')->constrained('account_school_details')
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('account_school_detail_seasons');
    }
}
