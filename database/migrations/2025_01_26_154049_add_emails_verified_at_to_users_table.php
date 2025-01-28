<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailsVerifiedAtToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the email_verified_at column exists before adding it
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable(); // Add this line if you want to create it
            }

            // Now add the emails_verified_at column
            if (!Schema::hasColumn('users', 'emails_verified_at')) {
                $table->timestamp('emails_verified_at')->nullable()->after('email_verified_at');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('emails_verified_at');
            $table->dropColumn('email_verified_at'); // Drop this if you added it
        });
    }
}