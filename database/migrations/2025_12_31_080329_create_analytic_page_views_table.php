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
        Schema::create('analytic_page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analytic_session_id')->constrained('analytic_sessions')->onDelete('cascade');
            $table->string('path');
            $table->timestamp('created_at');

            $table->index(['analytic_session_id', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytic_page_views');
    }
};
