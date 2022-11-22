<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->foreignId('sub_group_id')
            ->constrained('account_sub_groups')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->string('account',191);
            $table->double('opening_balance')->nullable();
            $table->string('transaction_type',191)->nullable();
            $table->date('opening_balance_date');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
