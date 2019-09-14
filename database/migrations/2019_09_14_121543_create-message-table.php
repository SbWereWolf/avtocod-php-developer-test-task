<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateMessageTable extends Migration
{
    const MESSAGE = 'message';
    const USERS_ID = 'users_id';
    const ID = 'id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::MESSAGE, function (Blueprint $table) {
            $table->increments(static::ID);
            $table->unsignedInteger(static::USERS_ID);
            $table->foreign(static::USERS_ID)
                ->references('id')->on('users');
            $table->string('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::MESSAGE);
    }
}
