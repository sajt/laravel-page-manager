<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_manager_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('headline')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('is_article')->default(1);
            $table->boolean('is_system')->default(0);
            
            $table->integer('language_id')->nullable();
            $table->integer('picture_id')->nullable();

            $table->string('internal_url')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('page_manager_pages');
    }
}
