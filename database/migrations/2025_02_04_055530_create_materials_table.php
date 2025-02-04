<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 250);
            $table->string('code', 100)->unique('materials_unique');
            $table->integer('item_type_id');
            $table->integer('storage_type_id');
            $table->integer('item_category_id');
            $table->integer('pallet_packaging_id');
            $table->integer('customer_id');
            $table->string('customer_code', 100)->nullable();
            $table->string('upc', 100)->nullable();
            $table->string('shelf_lift', 100)->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('materials');
    }
}
