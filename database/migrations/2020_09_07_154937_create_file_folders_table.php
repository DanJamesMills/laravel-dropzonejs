<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DanJamesMills\LaravelDropzone\Models\FileFolder;

class CreateFileFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->comment('The user that created the file folder.');
            $table->unsignedInteger('parent_file_folder_id')->nullable();
            $table->nullableMorphs('model');
            $table->string('name');
            $table->unsignedTinyInteger('access_type')->default(FileFolder::ACCESS_TYPE_ANYONE);
            $table->json('extra_attributes')->nullable();
            $table->boolean('system_default')->default(false)->comment('This will be true for default folders built into CRM.');
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
        Schema::dropIfExists('file_folders');
    }
}
