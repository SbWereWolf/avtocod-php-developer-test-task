<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class DropColumnEmailAtUsers extends Migration
{
    const USERS = 'users';
    const EMAIL = 'email';
    const EMAIL_IX = 'users_email_unique';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::USERS, function (Blueprint $table) {
            $table->dropColumn(self::EMAIL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::USERS, function (Blueprint $table) {
            $table->string(self::EMAIL)->default('default');
            $table->unique(self::EMAIL,self::EMAIL_IX);
        });
    }
}
