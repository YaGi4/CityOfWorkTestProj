<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->nullable(false);
            $table->string('second_name')->nullable(false);
            $table->string('patronymic')->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('first_name');
            $table->dropColumn('second_name');
            $table->dropColumn('patronymic');
        });
    }
};
