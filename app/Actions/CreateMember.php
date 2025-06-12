<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

final class CreateMember
{
    /**
     * Execute the action.
     *
     * @param  array{first_name: string, last_name: string, contact_number: string, email: string, date_joined: string, status: string}  $attributes
     */
    public function handle(array $attributes): Member
    {
        // broadcast(new MemberCreated($member))->toOthers();

        return DB::transaction(fn () => Member::create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'contact_number' => $attributes['contact_number'],
            'email' => $attributes['email'],
            'date_joined' => $attributes['date_joined'],
            'status' => $attributes['status'],
        ]));
    }
}
