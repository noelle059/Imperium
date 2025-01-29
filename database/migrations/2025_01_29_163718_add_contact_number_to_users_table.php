<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('contact_number')->nullable(); // Add this line
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('contact_number'); // Add this line
    });
}
};
