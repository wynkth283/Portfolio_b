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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('NameSkill');
            $table->unsignedBigInteger('title_skill_id'); // Khóa ngoại liên kết với title_skills
            $table->string('ClassIcon')->nullable();
            $table->boolean('StatusSkill')->default(true)->index();
            $table->timestamps();
            
            // Tạo khóa ngoại
            $table->foreign('title_skill_id')
                  ->references('id')
                  ->on('title_skills')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
