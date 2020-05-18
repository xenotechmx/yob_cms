<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryHasParentcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_has_parentcategory', function (Blueprint $table) {
            $table->integer('parent_category_id')->unsigned()->nullable();
            $table->foreign('parent_category_id')->references('id')
                  ->on('parent_categories')->onDelete('cascade');
      
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')
                  ->on('categories')->onDelete('cascade');
      
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
        Schema::dropIfExists('category_has_parentcategory');
    }
}
	