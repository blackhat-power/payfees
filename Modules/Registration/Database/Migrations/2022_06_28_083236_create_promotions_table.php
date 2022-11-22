<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('account_student_details');
            $table->foreignId('from_class')->constrained('account_school_detail_classes');
            $table->foreignId('to_class')->constrained('account_school_detail_classes');
            $table->foreignId('from_stream')->constrained('account_school_detail_streams')->nullable();
            $table->foreignId('to_stream')->constrained('account_school_detail_streams')->nullable();
            $table->tinyInteger('grad')->default(0);
            $table->string('status',191);
            $table->string('from_session',191);
            $table->string('to_session',191);
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
        Schema::dropIfExists('promotions');
    }
}
