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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->integer('id_po',11);
            $table->string('po_muat', 100);
            $table->string('po_kebun', 100);
            $table->date('tgl');
            $table->string('id_detail_ph',11);
            $table->double('qty', 15, 2);
            $table->decimal('price_curah', 15, 2);
            $table->decimal('total_curah', 15, 2);
            $table->decimal('price_container', 15, 2);
            $table->decimal('total_container', 15, 2);
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
        Schema::dropIfExists('purchase_orders');
    }
};
