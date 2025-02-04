<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalletPackagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet_packagings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('code', 100)->unique('pallet_packagings_unique');
            $table->string('name', 250);
            $table->integer('storage_type_id');
            $table->string('pallet_type', 100);
            $table->integer('status');
            $table->decimal('max_volume', 10, 3);
            $table->decimal('max_weight', 10, 3);
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
        Schema::dropIfExists('pallet_packagings');
    }
}
