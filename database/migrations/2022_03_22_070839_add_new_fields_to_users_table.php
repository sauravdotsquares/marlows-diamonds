<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email_verified_at');
            $table->string('nicename')->nullable()->after('remember_token');
            $table->integer('user_role')->after('nicename');
            $table->string('avatar')->nullable()->after('user_role');
            $table->text('description')->nullable()->after('avatar');
            $table->boolean('is_active')->default(1)->comment('1:Active, 0:Inactive')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('nicename');
            $table->dropColumn('user_role');
            $table->dropColumn('avatar');
            $table->dropColumn('description');
            $table->dropColumn('is_active');
        });
    }
}
