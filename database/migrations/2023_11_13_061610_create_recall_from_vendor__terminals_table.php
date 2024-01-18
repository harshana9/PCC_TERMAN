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
        Schema::create('recall_from_vendor__terminals', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('recall')->unsigned();
            $table->foreign('recall')->references('id')->on('recall_from_vendors');
            $table->string('merchant');
            $table->string('tid');
            $table->string('mid');
            $table->string('city');
            $table->string('remark')->nullable();
            $table->string('product_name');
            $table->string('serial_no');
            $table->enum('condition', [ 'JUNKED', 'USED']);
            $table->enum('connection_type', [ 'PSTN', 'GPRS']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recall_from_vendor__terminals');
    }
};
