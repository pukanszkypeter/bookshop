<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id');
            $table->foreign('reader_id')->references('id')->on('users');
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');
            $table->enum('status', ['PENDING', 'ACCEPTED', 'REJECTED', 'RETURNED']);
            $table->dateTime('request_processed_at')->nullable();
            $table->unsignedBigInteger('request_managed_by')->nullable();
            $table->foreign('request_managed_by')->references('id')->on('users');
            $table->string('request_processed_message', 255)->nullable();
            $table->dateTime('deadline')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->unsignedBigInteger('return_managed_by')->nullable();
            $table->foreign('return_managed_by')->references('id')->on('users');
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
        Schema::dropIfExists('borrows');
    }
}
