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
        Schema::create('head_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->string('boq_code');
            $table->string('v_name');
            $table->string('des');
            $table->string('uom');
            $table->string('qty');
            $table->string('rate');
            $table->string('amt');
            $table->string('gst');
            $table->string('gross');
            $table->string('remark');
            $table->date('head_date');
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
        Schema::dropIfExists('head_expenses');
    }
};
