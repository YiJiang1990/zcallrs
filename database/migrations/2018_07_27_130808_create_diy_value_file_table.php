<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiyValueFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diy_value_file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->index();
            $table->integer('diy_common_filed_id')->index();
            $table->integer('row_id')->index();
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
        Schema::dropIfExists('diy_value_file');
    }
}
