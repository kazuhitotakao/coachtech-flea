<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('user_id');
            /**
             * テーブル設計時に、データベース内にクレジットカード情報を持たせる予定だったが、
             * セキュリティの問題があるため、中止した。
             * 今後、他の用途で使えるかもしれないので、JASONで詳細情報を追加可能で残しておく。
             */
            $table->json('details')->nullable();
            $table->timestamps();

            // 外部キー制約
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
}
