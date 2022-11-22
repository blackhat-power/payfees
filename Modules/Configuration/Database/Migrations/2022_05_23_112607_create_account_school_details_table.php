<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');
            $table->string('name',191);
            $table->string('ownership',191);
            $table->string('registration_number',191);
            $table->string('current_session',191)->nullable();
            $table->string('logo',191);
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
        Schema::dropIfExists('account_school_details');
    }
}
