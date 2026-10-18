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
        Schema::create('doc_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('noc_user_id');
            $table->integer('app_id');
            $table->integer('doc_id');
            $table->string('doc_type')->nullable();
            $table->integer('doc_upload_ref')->nullable();
            $table->integer('noc_user_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('query_raised_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_file_uploads');
    }
};
