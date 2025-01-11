<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        $driver = DB::table('drivers')->orderBy('id', 'asc')->first();
        if ($driver) {
            DB::table('users')
                ->update(['driver_id' => $driver->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
        });
    }
};
