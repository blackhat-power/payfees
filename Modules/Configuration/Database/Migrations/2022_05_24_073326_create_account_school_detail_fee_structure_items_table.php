<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailFeeStructureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_detail_fee_structure_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('account_school_detail_fee_structure_id')
            ->constrained('account_school_detail_fee_structures')
            ->onDelete('restrict')
            ->onUpdate('cascade')
            ->index('fee_structure_id');
            $table->double('installments');
            $table->bigInteger('currency_id')->default(1);
            $table->double('exchange_rate')->default(1);
            $table->double('amount');
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
        Schema::dropIfExists('account_school_detail_fee_structure_items');
    }
}
