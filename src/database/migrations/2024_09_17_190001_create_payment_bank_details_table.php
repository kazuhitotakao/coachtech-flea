<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_method_id');
            $table->string('account_name', 255);
            $table->string('account_number', 255);
            $table->string('bank_name', 255);
            $table->string('branch_name', 255);
            $table->timestamps();

            // 外部キーの設定
            $table->foreign('payment_method_id')
            ->references('id')
            ->on('payment_methods')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_bank_details');
    }
}
