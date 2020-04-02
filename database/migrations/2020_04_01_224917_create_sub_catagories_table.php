<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCatagoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_catagories', function (Blueprint $table) {
            $table->bigIncrements(/** @lang text */ 'subcatagory_id');
            $table->string(/** @lang text */ 'subcatagory_name',50);
            $table->bigInteger('catagory_id');
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
        Schema::dropIfExists('sub_catagories');
    }
}
