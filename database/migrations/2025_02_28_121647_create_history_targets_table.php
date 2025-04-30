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
        Schema::create('history_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained('targets');
            $table->integer('jumlah_tercapai');
            $table->date('tanggal_tercapai');
            $table->string('description')->nullable();
            $table->string('media')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_targets');
    }
};
