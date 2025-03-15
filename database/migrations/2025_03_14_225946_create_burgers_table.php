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
        Schema::create('burgers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('prix', 8, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burgers');
    }
};
