<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('subscription_package_books', 'expired_date')) {
            Schema::table('subscription_package_books', function (Blueprint $table) {
                $table->dropColumn('expired_date');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('subscription_package_books', 'expired_date')) {
            Schema::table('subscription_package_books', function (Blueprint $table) {
                $table->date('expired_date')->nullable();
            });
        }
    }
};
