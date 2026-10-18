<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doc_filereceived_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->integer('app_id')->nullable();
            $table->integer('doc_id')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('doc_upload_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_filereceived_uploads');
    }
};
