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
        Schema::create('boqs', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->string('code');
            $table->string('des');
            $table->string('description');
            $table->string('unit');
            $table->string('qty');
            $table->string('boq_rate');
            $table->string('zero_rate');
            $table->string('boq_amount');
            $table->string('zero_amount');
            $table->string('remarks');
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
        Schema::dropIfExists('boqs');
    }
};
