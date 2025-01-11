<?php

use App\Models\User;
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

        Schema::table('offers', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'offers_id');
        });

        $user = User::orderBy('id', 'asc')->first();
        if ($user) {
            DB::table('offers')
            ->update([
                'offers_id' => $user->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('offers_id');
        });
    }
};
