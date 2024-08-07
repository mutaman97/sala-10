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
        Schema::create('supportmetas', function (Blueprint $table) {
            $table->unsignedBigInteger('support_id');
            $table->integer('type')->default(1);
            $table->text('comment');
            $table->timestamps();
            $table->foreign('support_id')->references('id')->on('supports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supportmetas');
    }
};
