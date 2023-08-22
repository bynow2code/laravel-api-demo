<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access_log', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('trace_id', 36)->nullable(false)->default('')->comment('请求id')->index();
            $table->string('method', 8)->nullable(false)->default('')->comment('请求方法');
            $table->string('path', 256)->nullable(false)->default('')->comment('请求路径');
            $table->mediumText('body')->comment('请求数据');
            $table->mediumText('response')->comment('响应内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_log');
    }
};
