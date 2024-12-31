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
        Schema::create('project_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id');
            $table->string('code');
            $table->string('des');
            $table->string('work');
            $table->string('unit');
            $table->string('qty');
            $table->string('pro_sale_rate');
            $table->string('pro_sale_amt');
            $table->string('pro_zero_rate');
            $table->string('pro_zero_amt');
            $table->string('remarks');
            $table->date('pro_date')->nullable();
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
        Schema::dropIfExists('project_sales');
    }
};
