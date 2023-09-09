<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_tracking_sisa', function (Blueprint $table) {
            $table->integer('id_track_sisa', 11);
            $table->string('id_track', 11);
            $table->decimal('qty_tonase_sisa', 15,2);
            $table->decimal('qty_total_tonase', 15,2);
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_tracking_sisa');
    }
};
