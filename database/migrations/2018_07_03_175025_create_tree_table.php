<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('position',['left', 'right']);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');

            $table->integer('left_user_id')->nullable();
            $table->integer('right_user_id')->nullable();
            $table->integer('direct_referral_id');

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
        Schema::dropIfExists('tree');
    }
}
