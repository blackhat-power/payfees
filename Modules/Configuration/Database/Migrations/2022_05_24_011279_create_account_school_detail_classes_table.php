<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_detail_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_school_detail_season_id')
                                                                ->constrained()
                                                                 ->index()
                                                                ->onDelete('restrict')
                                                                ->onUpdate('cascade')
                                                                ->nullable();
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->string('short_form')->nullable();
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
        Schema::dropIfExists('account_school_detail_classes');
    }
}
