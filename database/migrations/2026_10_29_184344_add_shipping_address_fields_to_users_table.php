
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable();
            $table->string('shipping_address', 500)->nullable();
            $table->string('street_address', 300)->nullable();
            $table->unsignedInteger('shipping_province_id')->nullable();
            $table->unsignedInteger('shipping_district_id')->nullable();
            $table->string('shipping_ward_code', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'shipping_address',
                'street_address',
                'shipping_province_id',
                'shipping_district_id',
                'shipping_ward_code',
            ]);
        });
    }
};
