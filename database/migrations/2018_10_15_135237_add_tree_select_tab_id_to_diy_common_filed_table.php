<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTreeSelectTabIdToDiyCommonFiledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diy_common_field', function (Blueprint $table) {
            $table->integer('tree_select_tab_id')->unsigned()->index()->default(0)->comment('选项树ID');
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
            $table->dropColumn('tree_select_tab_id');
        });
    }
}
