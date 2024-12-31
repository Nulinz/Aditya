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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('cmpname')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contactno')->unique();
            $table->string('database_name')->unique();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->default(1)->comment('1->active, 2->inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
