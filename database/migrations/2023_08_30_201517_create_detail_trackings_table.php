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
        Schema::create('detail_tracking', function (Blueprint $table) {
            $table->integer('id_detail_track',11);
            $table->string('id_track',11);
            $table->string('id_gudang', 11);
            $table->string('id_kapal', 11);
            $table->decimal('qty_tonase', 15,2);
            $table->decimal('qty_timbang', 15,2);
            $table->decimal('jml_sak', 15,2);
            $table->string('nopol', 15);
            $table->string('no_container', 20);
            $table->string('voyage', 20);
            $table->string('no_segel', 20);
            $table->date('tgl_muat');
            $table->date('td');
            $table->date('td_jkt');
            $table->date('ta');
            $table->string('no_sj',20);            
            $table->string('sj_file_name');
            $table->string('sj_file_path');
            $table->string('st_file_name');
            $table->string('st_file_path');            
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
        Schema::dropIfExists('detail_tracking');
    }
};
