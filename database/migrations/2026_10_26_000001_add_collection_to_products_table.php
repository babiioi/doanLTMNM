<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'collection')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('collection', 100)->nullable()->after('stock')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'collection')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('collection');
            });
        }
    }
};
