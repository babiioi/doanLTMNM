<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $now = now();
        foreach ([
            ['name' => 'BST Tí ta tí tởn', 'slug' => 'bst-ti-ta-ti-ton'],
            ['name' => 'BST Nhí nha nhí nhảnh', 'slug' => 'bst-nhi-nha-nhi-nhanh'],
            ['name' => 'BST Tếu ta tếu táo', 'slug' => 'bst-teu-ta-teu-tao'],
        ] as $row) {
            DB::table('collections')->updateOrInsert(['name' => $row['name']], $row + ['created_at' => $now, 'updated_at' => $now]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
