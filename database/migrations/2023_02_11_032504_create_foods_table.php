<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->integer('harga');
            $table->integer('stock');
            $table->string('slug');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->unsignedBigInteger('id_category')->nullable();
            $table->foreign('id_category')->on('categories')->references('id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
        Schema::table('foods', function (Blueprint $table) {
            $table->dropForeign('foods_id_category_foreign');
        });
        Schema::dropIfExists('foods');
    }
}