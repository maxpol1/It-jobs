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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('company_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('roles');
            $table->integer('category_id');
            $table->string('position');
            $table->string('address');
            $table->string('type');
            $table->integer('status');
            $table->date('last_date');
            $table->integer('number_of_vacancy');
            $table->integer('experience');
            $table->string('gender');
            $table->string('salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
