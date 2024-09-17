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
        Schema::table('patient_blood_oxygen', function (Blueprint $table) {
            $table->integer('pulse')->nullable()->after('saturation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_blood_oxygen', function (Blueprint $table) {
            $table->dropColumn(['pulse']);
        });
    }
};
