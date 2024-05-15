<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->string('code', 100);
            $table->string('name', 100);
            $table->tinyInteger('custom_url')->default(0);
            $table->text('url')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('category', 100);
            $table->integer('sequence')->default(0);
            $table->timestamps();

            $table->index(['parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
