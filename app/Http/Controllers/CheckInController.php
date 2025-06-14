<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Models\CheckIn;

final class CheckInController extends Controller
{
    public function index()
    {
        return CheckIn::all();
    }

    public function store(CheckInRequest $request)
    {
        return CheckIn::create($request->validated());
    }

    public function show(CheckIn $checkIn)
    {
        return $checkIn;
    }

    public function update(CheckInRequest $request, CheckIn $checkIn)
    {
        $checkIn->update($request->validated());

        return $checkIn;
    }

    public function destroy(CheckIn $checkIn)
    {
        $checkIn->delete();

        return response()->json();
    }
}
