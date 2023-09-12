<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('name_en');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('active');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
            $table->bigInteger('quantity')->default(0)->after('price');
            $table->enum('payment_method', ['visa', 'cache','wallet']);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            //
        });
    }
}
