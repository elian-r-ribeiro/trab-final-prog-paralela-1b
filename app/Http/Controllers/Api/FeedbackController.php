<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct(private readonly FeedbackService $feedbackService) {}

    public function index(Request $request)
    {
        return FeedbackResource::collection($this->feedbackService->index($request->all()));
    }

    public function store(Request $request)
    {
        return $this->feedbackService->store($request->all());
    }
}
