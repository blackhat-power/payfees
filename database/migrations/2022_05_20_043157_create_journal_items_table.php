<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreignId('cr_account_id')
                    ->constrained('accounts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('dr_account_id')
                    ->constrained('accounts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->double('amount');
            $table->string('naration',191);
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
        Schema::dropIfExists('journal_items');
    }
}
