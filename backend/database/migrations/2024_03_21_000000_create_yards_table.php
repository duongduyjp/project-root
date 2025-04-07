<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('yards', function (Blueprint $table) {
            $table->string('yard_code')->primary();
            $table->string('yard_name');
            $table->string('yard_phone');
            $table->string('yard_address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('yards');
    }
}; 