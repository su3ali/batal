<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('type')->after('id');
            $table->unsignedBigInteger('package_id')->nullable()->after('service_id');
            $table->foreign('package_id')->references('id')->on('contract_packages')->onDelete('cascade');
            $table->unsignedBigInteger('contract_order_id')->nullable()->after('order_id');;
            $table->foreign('contract_order_id')->references('id')->on('contracts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            //
        });
    }
}
