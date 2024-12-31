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
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->string('v_name');
            $table->string('code');
            $table->string('des');
            $table->string('uom');
            $table->string('qty');
            $table->string('b_rate');
            $table->string('amount');
            $table->string('gst');
            $table->string('gross');
            $table->string('remark');
            $table->date('lab_date');
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
        Schema::dropIfExists('labs');
    }
};
