<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailFeeStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('account_school_detail_fee_structures')) {
            Schema::create('account_school_detail_fee_structures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_school_details_class_id')->constrained('account_school_detail_classes')
                ->index('class_id');
                $table->foreignId('fee_group_id')->constrained(''.env('LANDLORD_DB_DATABASE').'.fee_groups')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
                $table->foreignId('created_by')->constrained('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
                $table->softDeletes();
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_school_detail_fee_structures');
    }
}
