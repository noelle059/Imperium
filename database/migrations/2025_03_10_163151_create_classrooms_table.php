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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key (Id)
            $table->string('classroom_name'); // for Classroom_name
            $table->unsignedBigInteger('floor_id'); // for Floor_id
            $table->boolean('archive_status')->default(true); // For the archive status (if TRUE visible, if FALSE hidden)
            $table->timestamps(); // created_at and updated_at timestamps

            // Adding foreign key constraint
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
