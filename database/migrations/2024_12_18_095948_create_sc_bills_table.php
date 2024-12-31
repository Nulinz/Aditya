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
        Schema::create('sc_bills', function (Blueprint $table) {
            $table->id();
            $table->string('boq_code');
            $table->string('sub_code');
            $table->integer('pro_id');
            $table->string('des');
            $table->string('v_name');
            $table->string('unit');
            $table->string('qty');
            $table->string('rate');
            $table->decimal('amount',10,2);
            $table->date('ap_on');
            $table->string('vr_by');
            $table->date('vr_on');
            $table->string('rc_by');
            $table->date('rc_on');
            $table->string('remarks');
            $table->date('sc_date');
            $table->string('cr_by');
            $table->date('cr_on');
            $table->string('ap_by');
            $table->boolean('status')->default(1)->comment('1->active, 2->inactive');
            $table->string('sc_file');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_bills');
    }
};
