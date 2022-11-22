<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->foreignId('user_id')->constrained()
                                        ->onDelete('restrict')
                                        ->onUpdate('cascade');
            $table->foreignId('type_id')->constrained()
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
