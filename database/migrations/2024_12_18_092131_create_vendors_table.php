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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('pro_id');
            $table->string('type');
            $table->string('v_code');
            $table->string('v_name');
            $table->string('address');
            $table->string('gst');
            $table->string('pan');
            $table->string('aadhar');
            $table->string('bank');
            $table->string('ac_name');
            $table->string('ac_no');
            $table->string('ifsc');
            $table->string('branch');
            $table->string('mob');
            $table->string('mail');
            $table->string('trade');
            $table->string('ven_date');
            $table->boolean('status')->default(1)->comment('1->active, 2->inactive');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
