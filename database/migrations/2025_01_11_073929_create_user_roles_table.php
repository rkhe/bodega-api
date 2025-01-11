<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
        });

        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'name' => 'SUPER'
            ],
            [
                'id' => 2,
                'name' => 'Administrator'
            ],
            [
                'id' => 3,
                'name' => 'Analyst'
            ],
            [
                'id' => 4,
                'name' => 'Controller'
            ],
            [
                'id' => 5,
                'name' => 'Checker'
            ],
            [
                'id' => 6,
                'name' => 'Forklift'
            ],
            [
                'id' => 7,
                'name' => 'Picker'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
