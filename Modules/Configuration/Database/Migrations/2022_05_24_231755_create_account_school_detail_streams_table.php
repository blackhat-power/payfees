<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSchoolDetailStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_school_detail_streams', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->string('description',191)->nullable();
            $table->foreignId('stream_id')->constrained(''.env('LANDLORD_DB_DATABASE').'.streams')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE')
            ->nullable();
            $table->foreignId('account_school_detail_class_id')
            ->constrained('account_school_detail_classes')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE')
            ->index('details_class_id');
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
        Schema::dropIfExists('account_school_detail_streams');
    }
}
