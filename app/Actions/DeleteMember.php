<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

final class DeleteMember
{
    /**
     * Execute the action.
     */
    public function handle(Member $member): bool
    {
        return DB::transaction(fn () => $member->delete());
    }
}
