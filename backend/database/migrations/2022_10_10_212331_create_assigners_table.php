<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('assigners', function (Blueprint $table) {
            $table->id();
            $table->integer("course_id");
            $table->integer("instructor_id");
            $table->timestamps();
        });
    }

    public function down(){
        
        Schema::dropIfExists('assigners');
    }
};
