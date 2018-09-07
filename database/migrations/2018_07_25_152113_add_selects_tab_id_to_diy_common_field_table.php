<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelectsTabIdToDiyCommonFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diy_common_field', function (Blueprint $table) {
            $table->integer('selects_tab_id')->unsigned()->index()->default(0)->comment('选项ID');
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
            $table->dropColumn('selects_tab_id');
        });
    }
}
