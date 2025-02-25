<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageAndIsReadToNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('message')->after('user_id'); // Add message column
            $table->boolean('is_read')->default(false)->after('message'); // Add is_read column with default value
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('message'); // Remove message column if rolled back
            $table->dropColumn('is_read'); // Remove is_read column if rolled back
        });
    }
}