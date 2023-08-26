<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_ticket_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trx_id',50);
            $table->integer('game_id');
            $table->decimal('amount',10,5);
            $table->dateTime('ticket_date');
            $table->dateTime('draw_date');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_ticket_transactions');
    }
};
