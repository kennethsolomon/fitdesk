<?php

declare(strict_types=1);

namespace App\Http\Requests\Member;

use App\Enums\Member\MemberStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CreateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:100'],
            'last_name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'min:3', 'max:100'],
            'contact_number' => ['required', 'string', 'min:3', 'max:100'],
            'date_joined' => ['date'],
            'status' => ['required', 'string', Rule::enum(MemberStatus::class)],
        ];
    }
}
