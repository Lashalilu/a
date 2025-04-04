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
        Schema::create('product_addition_detail_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_addition_detail_id');
            $table->string('locale')->index();
            $table->text('value');

            $table->unique(['product_addition_detail_id', 'locale'], 'padt_unique');

            $table->foreign('product_addition_detail_id', 'padt_fk')
                ->references('id')->on('product_addition_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_addition_detail_translations');
    }
};
