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
        Schema::create('petties', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->date('date');
            $table->string('v_no');
            $table->string('code');
            $table->string('des');
            $table->string('v_name');
            $table->string('unit');
            $table->string('qty');
            $table->string('rate');
            $table->string('amount');
            $table->string('remark');
            $table->integer('open_blnc');
            $table->string('in_img1');
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
        Schema::dropIfExists('petties');
    }
};
