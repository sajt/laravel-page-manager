<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerPageSectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_manager_page_section_items', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('page_section_id')->unsigned();
            $table->foreign('page_section_id')->references('id')->on('page_manager_page_sections')->onUpdate('cascade')->onDelete('cascade');
            
            $table->mediumText('content')->nullable();
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
        Schema::dropIfExists('page_manager_page_section_items');
    }
}
