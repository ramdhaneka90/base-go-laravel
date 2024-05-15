<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menu_has_permissions')) {
            $tableNames = config('permission.table_names');
            
            Schema::create('menu_has_permissions', function (Blueprint $table) use ($tableNames) {
                $table->uuid('permission_id');
                $table->uuid('menu_id');
                $table->string('name');
                $table->integer('sequence');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->foreign('menu_id')
                    ->references('id')
                    ->on('menus')
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'menu_id']);
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
        Schema::dropIfExists('menu_has_permissions');
    }
}
