<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CheckInRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members'],
            'check_in_time' => ['required', 'date'],
            'check_out_time' => ['nullable', 'date'],
            'amount_paid' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
