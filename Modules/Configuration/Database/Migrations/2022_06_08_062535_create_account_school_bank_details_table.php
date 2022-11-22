<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('payfeetz_landlord.bank_details')
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');
            $table->foreignId('account_school_detail_id')->constrained('account_school_details')
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');
            $table->string('account_no',191);

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
        Schema::dropIfExists('account_school_bank_details');
    }
}
