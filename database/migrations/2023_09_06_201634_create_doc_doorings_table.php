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
        Schema::create('doc_dooring', function (Blueprint $table) {
            $table->integer('id_dooring',11);
            $table->string('id_detail_track', 100);
            $table->string('sb_file_name');
            $table->string('sb_file_path');
            $table->string('sr_file_name');
            $table->string('sr_file_path');
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
        Schema::dropIfExists('doc_dooring');
    }
};
