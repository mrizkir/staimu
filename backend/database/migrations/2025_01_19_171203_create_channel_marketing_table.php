<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelMarketingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {   
    Schema::defaultStringLength(191);
    Schema::create('pe3_channel_marketing', function (Blueprint $table) {
      $table->uuid('id')->primary();            
      $table->string('namachannel');      

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
    Schema::dropIfExists('pe3_channel_marketing');
  }
}
