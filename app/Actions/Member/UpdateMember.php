<?php

declare(strict_types=1);

namespace App\Actions\Member;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

final class UpdateMember
{
    /**
     * Execute the action.
     *
     * @param  array{first_name: string, last_name: string, contact_number: string, email: string, status: string}  $attributes
     */
    public function handle(array $attributes, Member $member): Member
    {
        return DB::transaction(function () use ($attributes, $member) {
            $member->update([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'contact_number' => $attributes['contact_number'],
                'email' => $attributes['email'],
                'status' => $attributes['status'],
            ]);

            return $member->refresh(); // ensures the returned model has the latest data
        });
    }
}
