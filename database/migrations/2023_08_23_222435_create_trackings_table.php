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
        Schema::create('trackings', function (Blueprint $table) {
            $table->integer('id_track',11);
            $table->string('no_po', 100);
            $table->string('id_gudang', 100);
            $table->string('id_pol', 100);
            $table->string('id_pod', 100);
            $table->string('id_kapal', 100);
            $table->decimal('qty_muat', 15,2);
            $table->decimal('qty_timbang', 15,2);
            $table->decimal('jml_bag', 15,2);
            $table->string('nopol', 15);
            $table->string('no_container', 10);
            $table->string('voyage', 20);
            $table->date('td');
            $table->date('td_jkt');
            $table->date('eta');
            $table->string('file_name');
            $table->string('file_path');
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
        Schema::dropIfExists('trackings');
    }
};
