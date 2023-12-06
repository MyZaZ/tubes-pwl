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
        Schema::create('loandetails', function (Blueprint $table) {
            $table->id();
            $table->UnsignedbigInteger('loan_id');
            $table->boolean('is_return');
            $table->timestamps();
        });

        Schema::table('loandetails', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->after('loan_id');
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('returns', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_detail_id')->after('id');
            $table->foreign('loan_detail_id')
                  ->references('id')
                  ->on('loandetails')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('loandetails', function (Blueprint $table) {
            $table->foreign('loan_id')
                  ->references('id')
                  ->on('loans')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loandetails', function (Blueprint $table) {
            $table->dropForeign('loandetails_book_id_foreign');
            $table->dropColumn('book_id');

        });

        Schema::table('returns', function (Blueprint $table) {
            $table->dropForeign('returns_loan_detail_id_foreign');
            $table->dropColumn('loan_detail_id');

        });

        Schema::dropIfExists('loandetails');
    }
};
