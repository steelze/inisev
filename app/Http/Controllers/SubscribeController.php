<?php

namespace App\Http\Controllers;

use App\Helpers\RespondWith;
use App\Http\Requests\SubscribeRequest;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    public function store(SubscribeRequest $request, Website $website): JsonResponse
    {
        $userId = $request->user_id;
        $isSubscribed = $website->users()->where('user_id', $userId)->exists();

        if ($isSubscribed) {
            return RespondWith::error(null, 'User already subscribed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $website->users()->attach($userId);
        return RespondWith::success(null, 'User subscribed to website successfully');
    }
}
