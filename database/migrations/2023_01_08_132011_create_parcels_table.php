<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('source_address');
            $table->string('source_mobile');
            $table->double('source_lat');
            $table->double('source_long');

            $table->string('destination_name');
            $table->string('destination_address');
            $table->string('destination_mobile');
            $table->double('destination_lat');
            $table->double('destination_long');

            $table->index(['source_mobile', 'destination_mobile']);

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
        Schema::dropIfExists('parcels');
    }
};
