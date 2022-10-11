<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){
        
        Schema::create('classmates', function (Blueprint $table) {
            $table->integer("course_id");
            $table->integer("student_id");
            $table->timestamps();
            $table->primary(['course_id','student_id']);
        });
    }

    public function down(){

        Schema::dropIfExists('classmates');
    }
};
