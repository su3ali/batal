<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechniciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('specialization');
            $table->unsignedBigInteger('country_id');
            $table->string('identity_id');
            $table->date('birth_date');
            $table->string('image');
            $table->boolean('active')->default(1);
            $table->text('address');
            $table->unsignedBigInteger('wallet_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
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
        Schema::dropIfExists('technicians');
    }
}
