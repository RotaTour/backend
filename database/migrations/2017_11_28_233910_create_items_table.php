<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('place_id')->unsigned()->default(1);
            $table->foreign('place_id')->references('id')->on('places')
                ->onDelete('cascade');
            
            $table->integer('route_id');
            $table->foreign('route_id')->references('id')->on('routes')
            ->onDelete('cascade');

            $table->integer('order')->nullable();
            $table->string('action')->nullable();
            $table->boolean('done')->default(false);
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
        Schema::dropIfExists('items');
    }
}
