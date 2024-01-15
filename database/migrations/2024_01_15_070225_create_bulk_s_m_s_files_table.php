<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkSMSFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_s_m_s_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->string('message')->nullable();
            $table->tinyInteger('status')->enum(0,1)->defualt(0)->comment('0 for failed and 1 for success');
            $table->tinyInteger('type')->enum(1,2)->defualt(1)->comment('1 for portal and 2 for api');
            $table->dateTime('created_date_time')->defualt(now());
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
        Schema::dropIfExists('bulk_s_m_s_files');
    }
}
