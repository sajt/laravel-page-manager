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
            $table->boolean('is_system')->default(0);
            
            $table->integer('language_id')->nullable();
            $table->string('internal_url')->nullable();
            $table->string('slug');

            $table->integer('layout_id')->unsigned();
            $table->foreign('layout_id')->references('id')->on('page_manager_layouts')->onUpdate('cascade')->onDelete('cascade');

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
