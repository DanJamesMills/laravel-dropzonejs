<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->nullable()->comment('The user that created the file.');
            $table->foreignId('file_folder_id')->nullable();
            $table->uuid('token')->unique();
            $table->string('original_filename');
            $table->string('storage_filename');
            $table->string('mime_type')->nullable();
            $table->string('file_extension')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('disk');
            $table->string('path');
            $table->boolean('is_pre_upload')->default(false);
            $table->json('custom_properties')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
