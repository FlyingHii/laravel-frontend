<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('customer_email');
            $table->decimal('grand_total', 12, 4);
            $table->decimal('sub_total', 12, 4);
            $table->boolean('is_active');
            $table->timestamps();
        });
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('qty')->unsigned()->default(0);
            $table->string('sku');
            $table->string('name');
            $table->decimal('price', 12, 4);
            $table->decimal('total', 12, 4);
            $table->integer('product_id')->unsigned();
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('cart')->onDelete('cascade');
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
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_items');
    }
}
