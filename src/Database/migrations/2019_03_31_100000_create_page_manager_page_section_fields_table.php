<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerPageSectionFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_manager_page_section_fields', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('page_section_id')->unsigned();
            $table->foreign('page_section_id')->references('id')->on('page_manager_page_sections')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('field_type_id')->unsigned();
            $table->foreign('field_type_id')->references('id')->on('page_manager_field_types')->onUpdate('cascade')->onDelete('cascade');

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
