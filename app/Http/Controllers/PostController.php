<?php

namespace App\Http\Controllers;

use App\Helpers\RespondWith;
use App\Http\Requests\PostRequest;
use App\Jobs\SendPostToSubscribersJob;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(PostRequest $request, Website $website): JsonResponse
    {
        $post = $website->posts()->create($request->validated());
        SendPostToSubscribersJob::dispatch($post);
        return RespondWith::success($post);
    }
}
