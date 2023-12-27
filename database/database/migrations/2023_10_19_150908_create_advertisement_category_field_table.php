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
        Schema::create('advertisement_category_field', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('advertisement_id');
//            $table->foreignId('category_field_id');
            $table->unsignedBigInteger('advertisement_id');
            $table->unsignedBigInteger('category_field_id');
            $table->foreign('advertisement_id')->references('id')->on('advertisements')
                ->onDelete('CASCADE');
            $table->foreign('category_field_id')->references('id')->on('category_fields')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_category_field');
    }
};
