<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoriestask', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained(
                "tasks",
                "id"
            )->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained(
                "categories",
                "id"
            )->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoriestask');
    }
};