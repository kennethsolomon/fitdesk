<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateMember;
use App\Actions\DeleteMember;
use App\Actions\UpdateMember;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\DeleteMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class MemberController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Member::all());
    }

    public function store(CreateMemberRequest $request, CreateMember $action): RedirectResponse
    {
        /** @var array{first_name: string, last_name: string, contact_number: string, email: string, date_joined: string, status: string} $validated */
        $validated = $request->validated();
        $validated['date_joined'] = Carbon::now()->toDateTimeString();

        $action->handle(attributes: $validated);

        return redirect()->back();
    }

    public function update(UpdateMemberRequest $request, Member $member, UpdateMember $action): RedirectResponse
    {
        /** @var array{first_name: string, last_name: string, contact_number: string, email: string, status: string} $validated */
        $validated = $request->validated();

        $action->handle(attributes: $validated, member: $member);

        return redirect()->back();
    }

    public function destroy(DeleteMemberRequest $request, Member $member, DeleteMember $action): RedirectResponse
    {
        $action->handle(member: $member);

        return redirect()->back();
    }
}
