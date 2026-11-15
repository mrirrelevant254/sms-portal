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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_id')->constrained();
            $table->foreignId('campus_id')->constrained();
            $table->string('reg_no')->unique();
            $table->string('kuccps_id', 16)->nullable()->unique();
            $table->text('national_id')->nullable(); // We will encrypt this in the model
            $table->enum('id_doc_type', ['national_id', 'passport', 'birth_cert'])->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->unsignedTinyInteger('year_of_study')->default(1);
            $table->unsignedTinyInteger('semester_of_study')->default(1);
            $table->enum('status', ['active', 'deferred', 'withdrawn', 'graduated'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
