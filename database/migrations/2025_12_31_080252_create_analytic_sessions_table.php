<?php

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
        Schema::create('analytic_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_uuid')->unique();
            $table->timestamp('started_at');
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('page_count')->default(0);

            $table->index(['visitor_uuid', 'last_activity_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytic_sessions');
    }
};
