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
        Schema::create('termcategories', function (Blueprint $table) {

            $table->unsignedBigInteger('term_id'); //product id
            $table->unsignedBigInteger('category_id'); //category id

            $table->foreign('term_id')
            ->references('id')->on('terms')
            ->cascadeOnDelete();

            $table->foreign('category_id')
            ->references('id')->on('categories')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termcategories');
    }
};
