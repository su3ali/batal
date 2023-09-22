<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToTechniciansTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technicians', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('email')->unique()->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->string('identity_id')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->integer('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technicians', function (Blueprint $table) {
            //
        });
    }
}
