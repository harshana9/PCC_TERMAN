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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
	        $table->string('vendor_email')->nullable();
            $table->string('vendor_contact_1')->nullable();
            $table->string('vendor_contact_2')->nullable();
            $table->string('vendor_address')->nullable();
            $table->string('product')->nullable();
            $table->enum('connection_type', [ 'PSTN', 'GPRS']);
            $table->string('merchant');
            $table->string('tid');
            $table->string('mid');
            $table->string('city');
            $table->string('serial_no');
            $table->enum('condition', [ 'NEW', 'USED']);
            $table->enum('remove_condition', [ 'JUNKED', 'USED'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
