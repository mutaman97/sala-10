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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('role_id')->default(4); //3= seller 4 = customer 5 = rider
            $table->double('wallet')->nullable();
            $table->text('meta')->nullable();
            $table->text('permissions')->nullable();
            $table->string('phone')->nullable();
            $table->integer('status')->default(1);
            $table->string('email')->unique();
            $table->boolean('subscribed_to_newsletter')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
