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
        Schema::create('issue_masters', function (Blueprint $table) {
            $table->biginteger('prime')->unsigned()->unique();
            $table->integer('pro_id');
            $table->string('boq');
            $table->integer('Id');
            $table->integer('EntryNo');
            $table->date('EDate');
            $table->integer('SiteId');
            $table->integer('LocationId');
            $table->integer('ApproveId');
            $table->integer('ContractorId');
            $table->integer('SubContractorId');
            $table->string('EmpCode');
            $table->string('Chargeable');
            $table->string('Remarks');
            $table->integer('CriUser');
            $table->date('CriDate'); 
            $table->integer('Rtn');
            $table->integer('RtnNo');
            $table->string('IndentNo');
            $table->integer('IssuedBy');
            $table->string('SelfUse');
            $table->string('created_by');
            $table->timestamps(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_masters');
    }
};
