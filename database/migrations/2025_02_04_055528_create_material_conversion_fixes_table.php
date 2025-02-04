<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialConversionFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_conversion_fixes', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('material_id');
            $table->decimal('quantity', 10, 3);
            $table->string('uom', 100);
            $table->decimal('net_weight', 10, 3);
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
        Schema::dropIfExists('material_conversion_fixes');
    }
}
