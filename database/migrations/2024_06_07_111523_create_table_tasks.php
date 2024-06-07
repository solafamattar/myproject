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
        Schema::create('table_tasks', function (Blueprint $table) {
            $table->id();
            $table-> string('Task_Name');
            $table-> string('Task_Description');

            $table->foreignId('Department_ID ')->constrained('departments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tasks');
    }
};
