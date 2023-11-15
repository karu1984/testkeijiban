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
        Schema::table('userprofiles', function (Blueprint $table) {
             //ソフトデリート使うためのカラム
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userprofiles', function (Blueprint $table) {
             //ソフトデリート使うためのカラム削除
           $table->dropSoftDeletes();
        });
    }
};
