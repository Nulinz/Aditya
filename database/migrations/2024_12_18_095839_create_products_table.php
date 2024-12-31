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
        Schema::create('products', function (Blueprint $table) {
            $table->biginteger('prime')->unsigned()->unique();
            $table->integer('pro_id');
            $table->biginteger('Id')->unsigned()->unique();
            $table->string('Code');
            $table->string('Name');
            $table->string('PrintName');
            $table->string('ShortName');
            $table->integer('CateId');
            $table->integer('BrandId');
            $table->integer('SupplierId');
            $table->integer('UnitId');
            $table->decimal('OpenStock', 10, 2);
            $table->decimal('PRate', 10, 2);
            $table->decimal('WRate', 10, 2);
            $table->decimal('SRate', 10, 2);
            $table->decimal('Mrp', 10, 2);
            $table->string('Hsn');
            $table->decimal('MinQty', 10, 2);
            $table->decimal('ReOrder', 10, 2);
            $table->integer('TaxId');
            $table->date('CriDate');
            $table->string('Rack')->nullable();
            $table->string('Bin')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
