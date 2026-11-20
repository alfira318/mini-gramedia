<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->string('order_code');
            $table->dateTime('paid_date')->nullable();
            // diisi setelah pembayaran, jadi awalnya null
            $table->string('snap_token')->nullable();
            // diisi setelah midtrans ngasih, jadi awalnya null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn('order_code');
            $table->dropColumn('paid_date');
            $table->dropColumn('snap_token');
        });
    }
};
