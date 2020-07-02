<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('drug_name');
            $table->string('chemical_name');
            $table->string('manufacturer_country');
            $table->string('manufacturer_company');
            $table->string('distribution_company');
            $table->date('expire_date');
            $table->string('original_price');
            $table->string('selling_price');
            $table->integer('quantity');
            $table->unsignedInteger('user_id');

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
        Schema::dropIfExists('products');
    }
}
