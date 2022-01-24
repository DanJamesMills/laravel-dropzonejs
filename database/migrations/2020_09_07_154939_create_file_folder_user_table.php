<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileFolderUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_folder_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_folder_id')->references('id')->on('file_folders')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();

            $table->index(['file_folder_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_folder_user');
    }
}
