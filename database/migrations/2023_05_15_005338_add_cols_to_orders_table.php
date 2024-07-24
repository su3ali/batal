<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable()->change();
            $table->float('price')->nullable();
            $table->bigInteger('quantity')->default(0)->after('price')->nullable()->change();
            $table->float('discount')->after('user_id')->nullable();
            $table->double('sub_total')->after('discount')->nullable();
            $table->double('total')->after('sub_total')->nullable();
            $table->foreignId('user_address_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
