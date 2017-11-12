<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 16)->unique();
            $table->unsignedInteger('recipient_id')->nullable();
            $table->unsignedInteger('offer_id');
            $table->timestamp('expires_at');
            $table->timestamp('used_at');
            $table->timestamps();

            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
