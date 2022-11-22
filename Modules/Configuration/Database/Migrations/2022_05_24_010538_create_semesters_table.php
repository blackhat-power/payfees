<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_school_detail_season_id')->constrained('account_school_detail_seasons')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name',191);
            $table->string('descriptions',191);
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
        Schema::dropIfExists('semesters');
    }
}
