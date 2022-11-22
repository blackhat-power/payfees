<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_student_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',191);
            $table->string('middle_name',191)->nullable();
            $table->string('last_name',191);
            $table->enum('gender',['male','female']);
            $table->date('dob',191);
            $table->string('session',191);
            $table->string('admitted_year',191);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('grad')->default(0);
            $table->string('graduation_date',191)->nullable();
            $table->foreignId('account_school_details_id')
            ->constrained('account_school_details')
            ->onDelete('restrict')
            ->onUpdate('cascade')
            ->index('school_id');
            $table->foreignId('account_id')
            ->constrained('accounts')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->foreignId('account_school_details_class_id')
            ->constrained('account_school_detail_classes')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreignId('account_school_detail_stream_id')
            ->constrained('account_school_detail_streams')
            ->onDelete('restrict')
            ->onUpdate('cascade')
            ->nullable();
            $table->string('profile_pic',191)->nullable();

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
        Schema::dropIfExists('account_student_details');
    }
}
