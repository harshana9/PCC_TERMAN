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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->bigInteger('vendor')->unsigned();
            $table->foreign('vendor')->references('id')->on('vendors');
            $table->enum('connection_type', [ 'PSTN', 'GPRS']);
            $table->string('description')->nullable();

            $table->bigInteger('stock_new_vendor')->default('0');
            $table->bigInteger('stock_new_supplies')->default('0');
            $table->bigInteger('stock_new_pcc')->default('0');
            $table->bigInteger('stock_used_vendor')->default('0');
            $table->bigInteger('stock_used_supplies')->default('0');
            $table->bigInteger('stock_used_pcc')->default('0');
            $table->bigInteger('stock_deployed')->default('0');
            $table->bigInteger('stock_junked')->default('0');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
