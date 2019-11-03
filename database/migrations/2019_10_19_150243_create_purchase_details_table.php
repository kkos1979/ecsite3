<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('purchasedetails', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('purchase_id');
          $table->integer('item_id');
          $table->integer('price');
          $table->integer('total_price');
          $table->integer('quantity');
          $table->string('date');
          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasedetails');
    }
}
