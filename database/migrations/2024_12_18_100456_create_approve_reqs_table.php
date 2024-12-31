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
        Schema::create('approve_reqs', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->date('rate_date');
            $table->string('boq_code');
            $table->string('sub_code');
            $table->string('unit');
            $table->string('mh_rate');
            $table->string('unit_rate');
            $table->string('tlt_rate');
            $table->string('rcm_rate');
            $table->string('cont_profit');
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
        Schema::dropIfExists('approve_reqs');
    }
};
