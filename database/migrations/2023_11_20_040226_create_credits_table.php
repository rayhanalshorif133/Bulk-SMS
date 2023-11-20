<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// /import
use Database\Seeders\DatabaseSeeder;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sender_info_id')->constrained('sender_infos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('fund_id')->constrained('funds')->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount', 15, 2)->comment('Taka');
            $table->integer('balance')->comment('sms count');
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('active')->enam('active','inactive');
            $table->timestamps();
        });


        $dbseed = new DatabaseSeeder();
        $dbseed->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
}
