<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MemberStatus;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'status' => MemberStatus::class,
        ];
    }
}
