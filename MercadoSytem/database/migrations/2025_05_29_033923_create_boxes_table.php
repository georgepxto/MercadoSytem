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
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->after('id');
            $table->string('number')->unique(); // número do box
            $table->string('location'); // localização no mercado
            $table->text('description')->nullable();
            $table->boolean('available')->default(true);
            $table->decimal('monthly_price', 8, 2)->nullable(); // preço mensal
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
        Schema::dropIfExists('boxes');
    }
};
