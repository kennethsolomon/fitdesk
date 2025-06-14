<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscription;

use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CreateSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::enum(SubscriptionType::class)],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'amount_paid' => ['nullable', 'integer'],
            'duration' => ['nullable', 'integer'],
            'status' => ['required', 'string', Rule::enum(SubscriptionStatus::class)],

            'member_id' => ['required', 'exists:members,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
