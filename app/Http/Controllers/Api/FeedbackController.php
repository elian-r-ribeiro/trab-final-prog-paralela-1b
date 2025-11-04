<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
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

    public function update(UpdateFeedbackRequest $request, string $id)
    {
        return response()->json(['data' => new FeedbackResource($this->feedbackService->update($request->validated(), $id))]);
    }

    public function store(CreateFeedbackRequest $request)
    {

        $data = $request->validated();

        return response()->json([
            'message' => 'Feedback criado com sucesso.',
            'data' =>  new FeedbackResource($this->feedbackService->store($data))
        ], 201);
    }

    public function show(string $id)
    {
        return new FeedbackResource($this->feedbackService->show($id));
    }

    public function destroy(string $id)
    {
        return $this->feedbackService->destroy($id);
    }
}
