<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscription;

use App\Enums\Subscription\SubscriptionStatus;
use App\Enums\Subscription\SubscriptionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateSubscriptionRequest extends FormRequest
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
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'amount_paid' => ['required', 'integer', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', Rule::enum(SubscriptionStatus::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
