<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->integer("instructor_id");
            $table->integer("course_id");
            $table->string("assignment_text");
            $table->timestamps();
        });
    }

    public function down(){
        
        Schema::dropIfExists('assignments');
    }
};
