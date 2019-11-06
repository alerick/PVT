<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_reference', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loan_id'); // id persona de referencia
            $table->foreign('loan_id')->references('id')->on('loans'); 
            $table->string('full_name');
            $table->string('address')->nullable();;
            $table->integer('cell_phone')->nullable();;
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
        Schema::dropIfExists('personal_reference');
    }
}
