<?php

use App\Models\MonitoringCategory;
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
        Schema::create('monitoring_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('device');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        MonitoringCategory::create([
            'slug' => 'weight',
            'name' => 'Weight',
            'device' => 'Scale',
        ]);

        MonitoringCategory::create([
            'slug' => 'blood_pressure',
            'name' => 'Blood Preasure',
            'device' => 'Blood Preasure Monitor',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_categories');
    }
};
