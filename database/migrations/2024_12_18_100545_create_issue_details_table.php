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
        Schema::create('issue_details', function (Blueprint $table) {
            $table->biginteger('prime')->unsigned()->unique();
            $table->integer('pro_id');
            $table->string('boq');
            $table->integer('Id');
            $table->integer('EntryNo');
            $table->date('EDate');
            $table->integer('Pid');
            $table->decimal('Qty',10,2);
            $table->decimal('Rate',10,2);
            $table->decimal('Amount',10,2);
            $table->integer('CriUser');
            $table->date('CriDate');
            $table->string('Rtn');
            $table->decimal('Balance',10,2);
            $table->integer('UnitId');
            $table->integer('OriUnitId');
            $table->string('Purpose');
            $table->date('RtnDt');
            $table->string('RtnFlag');
            $table->string('CostCode');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_details');
    }
};
