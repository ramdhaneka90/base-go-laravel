<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('division_id')->index();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('division_id')
                ->references('id')
                ->on('division')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('position_id')
                ->references('id')
                ->on('position')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('position');
    }
}
