<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerLayoutSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_manager_layout_sections', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('layout_id')->unsigned();
            $table->foreign('layout_id')->references('id')->on('page_manager_layouts')->onUpdate('cascade')->onDelete('cascade');

            $table->string('block');
            $table->string('caption');

            $table->boolean('is_list')->default(0);
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
        Schema::dropIfExists('page_manager_layout_sections');
    }
}
