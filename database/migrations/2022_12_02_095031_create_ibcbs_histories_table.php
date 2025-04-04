<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbcbsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section5_ibcbs_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ibcb_id')->nullable()->comment('id ตาราง section5_ibcbs');
            $table->string('data_field')->nullable()->comment('ชื่อฟิลด์');
            $table->text('data_old')->nullable()->comment('ข้อมูลเดิม');
            $table->text('data_new')->nullable()->comment('ข้อมูลใหม่');
            $table->text('remark')->nullable()->comment('หมายเหตุ');
            $table->dateTime('created_at')->comment('วันเวลาที่สร้าง');
            $table->integer('created_by')->nullable()->comment('id ตาราง user_register');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section5_ibcbs_history');
    }
}
