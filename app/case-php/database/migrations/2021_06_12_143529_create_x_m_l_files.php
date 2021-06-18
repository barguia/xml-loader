<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXMLFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xml_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('file_name')->nullable();
            $table->string('ext');
            $table->string('redis_key')->nullable();
            $table->tinyInteger('success')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->timestamp('finalized_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xml_files');
    }
}
