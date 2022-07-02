<?php

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Rental::MAP_CAR_ID)
                ->foreign(Rental::MAP_CAR_ID)
                ->references(Car::MAP_ID)
                ->on(Car::TABLE)
                ->onDelete('cascade');
            $table->date(Rental::MAP_START_DATE);
            $table->date(Rental::MAP_END_DATE);
            $table->integer(Rental::MAP_DISTANCE);
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
        Schema::dropIfExists('rentals');
    }
};
