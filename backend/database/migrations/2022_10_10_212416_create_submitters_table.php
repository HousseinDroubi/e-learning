<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('submitters', function (Blueprint $table) {
            $table->id();
            $table->integer("assignment_id");
            $table->integer("student_id");
            $table->string("submit");
            $table->timestamps();
        });
    }

    public function down(){
        
        Schema::dropIfExists('submitters');
    }
};
