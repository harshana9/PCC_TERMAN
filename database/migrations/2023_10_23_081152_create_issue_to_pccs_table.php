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
        Schema::create('issue_to_pccs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('vendor_name');
	        $table->string('vendor_email')->nullable();
            $table->string('vendor_contact_1')->nullable();
            $table->string('vendor_contact_2')->nullable();
            $table->string('vendor_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_to_pccs');
    }
};
