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
        Schema::create('replace__terminals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('replace')->unsigned();
            $table->foreign('replace')->references('id')->on('replaces');
            $table->date('date');
            $table->string('merchant');
            $table->string('tid');
            $table->string('mid');
            $table->string('city');
            $table->string('remark')->nullable();

            $table->string('old_product');
            $table->string('serial_no_old');
            $table->enum('old_connection_type', [ 'PSTN', 'GPRS']);
            $table->enum('old_machine_condition', [ 'JUNKED', 'USED']);

            $table->string('new_product');
            $table->string('serial_no_new');
            $table->enum('new_machine_condition', [ 'NEW', 'USED']);
            $table->enum('new_connection_type', [ 'PSTN', 'GPRS']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replace__terminals');
    }
};
