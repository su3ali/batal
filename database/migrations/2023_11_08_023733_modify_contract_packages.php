<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyContractPackages extends Migration
{
    public function up()
    {
        Schema::table('contract_packages', function (Blueprint $table) {
            $table->dropForeign('contract_packages_service_id_foreign');
            $table->dropColumn('service_id');
        });
    }

    public function down()
    {
        Schema::table('contract_packages', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
