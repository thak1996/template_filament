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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->unique()->after('email');
            $table->boolean('is_accountant')->default(false)->after('language');
            $table->boolean('has_cnpj')->nullable()->after('is_accountant');
            $table->string('representation_document')->nullable()->after('has_cnpj');
            $table->string('accounting_cnpj', 18)->nullable()->after('representation_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'cpf',
                'is_accountant',
                'has_cnpj',
                'representation_document',
                'accounting_cnpj',
            ]);
        });
    }
};
