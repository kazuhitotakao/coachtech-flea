<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');  // 主キー
            $table->unsignedBigInteger('item_id');  // 商品ID
            $table->unsignedBigInteger('buyer_id');  // 購入者ID
            $table->unsignedBigInteger('seller_id');  // 出品者ID
            $table->unsignedBigInteger('payment_detail_id')->nullable();;  // 支払方法詳細(null許容)
            $table->unsignedBigInteger('address_id')->nullable();;  // 配送先(null許容)
            $table->decimal('paid_price', 9, 2);  // 支払金額（小数点以下2桁）
            $table->timestamps();  // created_at, updated_at

            // 外部キー制約の設定
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_detail_id')->references('id')->on('payment_details')->onDelete('set null');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
