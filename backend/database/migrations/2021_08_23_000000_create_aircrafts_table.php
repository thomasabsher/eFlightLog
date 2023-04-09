<?php // todo fix tag

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAircraftsTable extends Migration
{
    public function up()
    {
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_user')->nullable();
            $table->unsignedBigInteger('updated_by_user')->nullable();
            $table->string

("make")->nullable();
            $table->string

("model")->nullable();
            $table->string

("registration")->nullable();
            $table->integer

("year")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aircrafts');
    }
}

