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
        Schema::create('deploy__terminals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deploy')->unsigned();
            $table->foreign('deploy')->references('id')->on('deploys');
            $table->date('date');
            $table->string('merchant');
            $table->string('tid');
            $table->string('mid');
            $table->string('city');
            $table->string('serial_no');
            $table->string('remark')->nullable();
            $table->enum('condition', [ 'NEW', 'USED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('deploy__terminals');
    }
};