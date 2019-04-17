<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageManagerPageSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_manager_page_sections', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('page_manager_pages')->onUpdate('cascade')->onDelete('cascade');

            $table->string('block');
            $table->string('caption');

            $table->mediumText('content')->nullable();
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('page_manager_page_sections');
    }
}
