<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('subject_code'); // For the subject code
            $table->string('subject_name'); // For the subject name
            $table->integer('units'); // For the number of units
            $table->boolean('archive_status')->default(true); // For the archive status (if TRUE visible, if FALSE hidden)
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
