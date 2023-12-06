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
        Schema::create('bookshelfs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('bookshelfs_id')->after('quantity');
            $table->foreign('bookshelfs_id')
                  ->references('id')
                  ->on('bookshelfs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign('books_bookshelfs_id_foreign');
            $table->dropColumn('bookshelfs_id');

        });

        Schema::dropIfExists('bookshelfs');
    }
};
