<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_builders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 400)->nullable()->default('');
            $table->longText('content');
            $table->text('js');
            $table->text('css');
            $table->text('custom_js');
            $table->text('custom_css');
            $table->integer('author_id');
            $table->string('status', 60)->default('published');
            $table->string('image', 255)->nullable();
            $table->integer('is_public');
            $table->string('layout', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_builders');
    }
};
