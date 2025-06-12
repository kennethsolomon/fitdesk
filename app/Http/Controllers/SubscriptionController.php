<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Subscription\CreateSubscription;
use App\Enums\Member\MemberStatus;
use App\Http\Requests\Subscription\CreateSubscriptionRequest;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class SubscriptionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Subscription::all());
    }

    public function store(CreateSubscriptionRequest $request, Member $member, CreateSubscription $action): RedirectResponse
    {
        // Check if the member exists.
        if ($member->status !== MemberStatus::Active) {
            return redirect(route('subscriptions.index'))
                ->withErrors(['member' => 'Only active members can be subscribed.']);
        }

        // Only one subscription per member is allowed.
        if ($member->subscriptions()->exists() && $member->subscriptions()->where('status', '!=', 'expired')->exists()) {
            return redirect(route('subscriptions.index'))
                ->withErrors(['member' => 'This member already has an active subscription.']);
        }

        /** @var array{type: string, start_date: string, end_date: string, amount_paid: int, duration: int, status: string}  $validated */
        $validated = $request->validated();

        $action->handle(attributes: $validated, member: $member);

        return redirect(route('subscriptions.index'));
    }
}
