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
        Schema::create('service_class_tariffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_class_id')->nullable();
            $table->string('payer_type'); # [general, bpjs, insurance, corporate]
            $table->decimal('daily_rate', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('service_class_id')
                ->references('id')
                ->on('service_classes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_class_tariffs');
    }
};
