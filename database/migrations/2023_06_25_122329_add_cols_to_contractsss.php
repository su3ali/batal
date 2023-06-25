<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToContractsss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->float('discount')->after('user_id')->nullable();
            $table->double('sub_total')->after('discount')->nullable();
            $table->double('total')->after('sub_total')->nullable();
            $table->foreignId('user_address_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractsss', function (Blueprint $table) {
            //
        });
    }
}
