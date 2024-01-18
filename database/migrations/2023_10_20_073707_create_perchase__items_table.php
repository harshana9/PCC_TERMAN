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
        Schema::create('perchase__items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('perchase')->unsigned();
            $table->foreign('perchase')->references('id')->on('perchases');
            $table->string('product_name');
            $table->string('connection_type');
            $table->string('description');
            $table->string('serial_first');
            $table->string('serial_last');
            $table->bigInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perchase__items');
    }
};
