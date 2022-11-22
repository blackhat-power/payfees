<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_sub_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->foreignId('account_group_id')->contrained(''.env('LANDLORD_DB_DATABASE').'.charts_of_account_groups'.'')
            ->onDelete('restrict');
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
        Schema::dropIfExists('account_sub_groups');
    }
}
