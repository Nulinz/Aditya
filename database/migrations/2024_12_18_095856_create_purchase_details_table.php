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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->integer('prime');
            $table->integer('pro_id');
            $table->string('boq');
            $table->integer('Id');
            $table->integer('Eid');
            $table->date('EDate');
            $table->integer('Pid');
            $table->decimal('Qty');
            $table->integer('UnitId');
            $table->integer('OriUnitId');
            $table->string('Barcode');
            $table->decimal('PRate', 10, 2);
            $table->decimal('WRate', 10, 2);
            $table->decimal('SRate', 10, 2);
            $table->decimal('Mrp', 10, 2);
            $table->integer('TaxId');
            $table->decimal('CgstPerc', 10, 2);
            $table->decimal('CgstAmount', 10, 2);
            $table->decimal('SgstPerc', 10, 2);
            $table->decimal('SgstAmount', 10, 2);
            $table->decimal('IgstPerc', 10, 2);
            $table->decimal('IgstAmount', 10, 2);
            $table->string('Info1');
            $table->string('Info2');
            $table->string('Info3');
            $table->string('Info4');
            $table->integer('CriUser');
            $table->date('CriDate');
            $table->decimal('Amount', 10, 2);
            $table->decimal('DiscPerc', 10, 2);
            $table->decimal('DiscAmount', 10, 2);
            $table->decimal('OriPrate', 10, 2);
            $table->integer('Yr');
            $table->integer('Sid');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
