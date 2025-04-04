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
        Schema::table('product_addition_details', function (Blueprint $table) {
            $table->dropColumn('detail_key');
        });

        Schema::table('product_addition_detail_translations', function (Blueprint $table) {
            $table->string('detail_key')->after('locale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_addition_details', function (Blueprint $table) {
            $table->string('detail_key')->nullable();
        });

        Schema::table('product_addition_detail_translations', function (Blueprint $table) {
            $table->dropColumn('detail_key');
        });
    }
};
