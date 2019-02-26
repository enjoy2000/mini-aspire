<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interest_rate')->unsigned();
            $table->integer('period_in_months')->unsigned();
            $table->integer('repayment_frequency_in_months')->unsigned();
            $table->decimal('arrangement_fee')->unsigned();
            $table->timestamps();
        });
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages');
            $table->date('start_date');
            $table->decimal('amount');
            $table->timestamps();
        });
        Schema::create('repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id')->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans');
            $table->date('due_date');
            $table->date('paid_date')->nullable(true);
            $table->decimal('amount');
            $table->timestamps();
        });
        Schema::create('repayment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repayment_id')->unsigned();
            $table->foreign('repayment_id')->references('id')->on('repayments');
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
        Schema::dropIfExists('packages');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('repayments');
        Schema::dropIfExists('repayment_histories');
    }
}
