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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->string('code');
            $table->date('pur_date');
            $table->string('pur_bill');
            $table->string('ven_name');
            $table->string('item_code');
            $table->string('material');
            $table->string('uom');
            $table->decimal('qty',10,2);
            $table->decimal('b_rate',10,2);
            $table->decimal('amount',10,2);
            $table->decimal('gst',10,2);
            $table->decimal('gross',10,2);
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
        Schema::dropIfExists('purchases');
    }
};
