<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiyValueOptionTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diy_value_option_tree', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tree_select_val_id')->unsigned()->index();
            $table->integer('diy_common_filed_id')->index();
            $table->integer('row_id')->index();
            $table->timestamps();

            $table->foreign('tree_select_val_id')
                ->references('id')
                ->on('tree_select_val')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diy_value_option_tree');
    }
}
