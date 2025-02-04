<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallets', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 100);
            $table->integer('location_id')->nullable();
            $table->integer('pallet_packaging_id')->nullable();
            $table->integer('item_type_id')->nullable();
            $table->integer('storage_type_id')->nullable();
            $table->integer('status');
            $table->string('notes', 100)->nullable();
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
        Schema::dropIfExists('pallets');
    }
}
