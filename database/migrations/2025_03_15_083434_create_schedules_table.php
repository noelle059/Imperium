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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade'); // Assuming 'classrooms' is the name of the related table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Assuming 'users' is the name of the related table
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Assuming 'subjects' is the name of the related table
            $table->time('start_time');
            $table->time('end_time');
            $table->date('schedule_day'); // Changed to 'date' type to store a specific date
            $table->boolean('archive_status')->default(true); // For the archive status (if TRUE visible, if FALSE hidden)
            $table->timestamps(); // This will automatically create `created_at` and `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
