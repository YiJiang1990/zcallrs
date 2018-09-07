<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHasImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_has_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->index();
            $table->unsignedInteger('images_id')->index();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
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
        Schema::dropIfExists('product_has_images');
    }
}
