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
        Schema::create('parcel_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->boolean('is_active');

            $table->foreignId('parcel_id');
            $table->foreign('parcel_id')
                ->references('id')
                ->on('parcels')
                ->onDelete('cascade');

            $table->index(['parcel_id']);

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
        Schema::dropIfExists('parcel_statuses');
    }
};
