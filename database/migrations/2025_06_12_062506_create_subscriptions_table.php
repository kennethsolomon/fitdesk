<?php

declare(strict_types=1);

use App\Models\Member;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Member::class)->constrained('members');
            $table->string('type');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('amount_paid')->nullable();
            $table->integer('duration')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
