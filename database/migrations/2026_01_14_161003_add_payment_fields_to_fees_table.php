<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->foreignId('fee_structure_id')->nullable()->after('id')->constrained('fee_structures')->onDelete('set null');
            $table->decimal('discount', 10, 2)->default(0)->after('amount');
            $table->string('payment_method')->nullable()->after('paid_date'); // cash, bank, online
            $table->text('payment_notes')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropForeign(['fee_structure_id']);
            $table->dropColumn(['fee_structure_id', 'discount', 'payment_method', 'payment_notes']);
        });
    }
};
