<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('api_key')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('mobile_number')->nullable();
            $table->longtext('message')->nullable();
            $table->string('our_api')->nullable();
            $table->string('our_api_response')->nullable();
            $table->tinyInteger('status')->enum(0,1)->defualt(0)->comment('0 for failed and 1 for success');
            $table->tinyInteger('type')->enum(1,2,3)->defualt(1)->comment('1 for portal, 2 for api, 3 for bulk sms');
            $table->string('customer_response')->nullable();
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
        Schema::dropIfExists('s_m_s_logs');
    }
}
