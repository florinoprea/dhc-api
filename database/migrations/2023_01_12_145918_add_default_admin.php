<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        $hasAdmin = DB::table('users')->where('email', '=', env('DEFAULT_ADMIN_EMAIL', 'admin@dhc.com'))->first();
        if (is_null($hasAdmin))
            DB::table('users')->insert(
                array(
                    'first_name' => 'Admin',
                    'last_name' => 'DHC',
                    'email' => env('DEFAULT_ADMIN_EMAIL', 'admin@dhc.com'),
                    'password' => Hash::make((env('DEFAULT_ADMIN_PASSWORD', 'super123!'))),
                    'is_admin' => true,
                    'active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
