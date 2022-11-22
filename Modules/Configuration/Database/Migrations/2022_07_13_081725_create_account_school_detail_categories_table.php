<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_detail_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('payfeetz_landlord.categories')
                    ->onDelete('RESTRICT')
                    ->onUpdate('CASCADE');
            $table->foreignId('school_id')->constrained('account_school_details')
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');

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
        Schema::dropIfExists('account_school_detail_categories');
    }
}
