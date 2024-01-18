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
        Schema::create('issue_to_vendor_new__items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('issue_to_vendor_new')->unsigned();
            $table->foreign('issue_to_vendor_new')->references('id')->on('issue_to_vendor_news');
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
        Schema::dropIfExists('issue_to_vendor_new__items');
    }
};
