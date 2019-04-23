<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerLayoutSectionFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_manager_layout_section_fields', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('layout_section_id')->unsigned();
            $table->foreign('layout_section_id')->references('id')->on('page_manager_layout_sections')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('type')->default('text');
            $table->string('name');
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
        Schema::dropIfExists('page_manager_page_section_fields');
    }
}
