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
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID (Primary Key)
            $table->unsignedBigInteger('classroom_id'); // Foreign key to the classrooms table
            $table->string('device_name'); // Device name (e.g., projector, speaker, etc.)
            $table->boolean('state')->default(false); // State of the device (true/false)
            $table->boolean('archive_status')->default(true); // For the archive status (if TRUE visible, if FALSE hidden)
            $table->timestamps(); // created_at and updated_at columns

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
