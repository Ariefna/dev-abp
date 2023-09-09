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
        Schema::create('detail_dooring', function (Blueprint $table) {
            $table->integer('id_detail_door',11);
            $table->string('id_dooring',11);
            $table->date('tgl_muat');
            $table->date('tgl_tiba');
            $table->string('nopol', 15);
            $table->decimal('qty_tonase', 15,2);
            $table->decimal('qty_timbang', 15,2);
            $table->decimal('jml_sak', 15,2);
            $table->string('no_sj',20);
            $table->string('sj_file_name');
            $table->string('sj_file_path');
            $table->string('no_tiket', 20);
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
        Schema::dropIfExists('detail_dooring');
    }
};
