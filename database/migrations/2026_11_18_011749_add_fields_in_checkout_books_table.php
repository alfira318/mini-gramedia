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
        Schema::table('checkout_books', function (Blueprint $table) {
            $table->foreignId('subscription_package_id')
                ->nullable()
                ->constrained('subscription_packages')
                ->cascadeOnDelete();

            // untuk mendeteksi buku ini dibeli dengan satuan atau paket langganan
            $table->integer('price');

            // untuk menyimpan harga yang dibeli dari satu buku tersebut
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkout_books', function (Blueprint $table) {
            $table->dropForeign(['subscription_package_id']);
            // hapus keterangan fk nya dulu, baru dibawahnya hps kolomnya
            $table->dropColumn('subscription_package_id');
            $table->dropColumn('price');
        });
    }
};
