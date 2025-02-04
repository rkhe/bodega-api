<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_materials', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('material_id');
            $table->integer('location_id');
            $table->decimal('quantity', 10, 3);
            $table->string('uom', 50);
            $table->decimal('net_weight', 10, 3);
            $table->decimal('net_volume', 10, 3);
            $table->date('manufacturing_date');
            $table->date('expiry_date');
            $table->string('batch', 15);
            $table->integer('status');
            $table->string('notes', 250)->nullable();
            $table->decimal('initial_quantity', 10, 3);
            $table->decimal('quantity_picking', 10, 3)->default(0.000);
            $table->decimal('quantity_dispatching', 10, 3)->default(0.000);
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
        Schema::dropIfExists('location_materials');
    }
}
