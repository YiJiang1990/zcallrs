<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToDiyCommonFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diy_common_field', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('状态0禁用，1开启');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diy_common_field', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
