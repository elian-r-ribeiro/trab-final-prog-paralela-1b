<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuestionOptionRequest;
use App\Http\Requests\UpdateQuestionOptionRequest;
use App\Http\Resources\QuestionOptionResource;
use App\Http\Services\QuestionOptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    public function __construct(private readonly QuestionOptionService $questionOptionService) {}

    public function index(Request $request)
    {
        return QuestionOptionResource::collection($this->questionOptionService->index($request->all()));
    }

    public function store(CreateQuestionOptionRequest $request): JsonResponse
    {

        $data = $request->validated();

        return response()->json([
            'message' => 'Questão criada com sucesso.',
            'data' =>  new QuestionOptionResource($this->questionOptionService->store($data))
        ], 201);
    }

    public function update(UpdateQuestionOptionRequest $request, string $id)
    {
        return response()->json(['data' => $this->questionOptionService->update($request->validated(), $id)]);
    }

    public function show(string $id)
    {
        return new QuestionOptionResource($this->questionOptionService->show($id));
    }

    public function destroy(string $id)
    {
        return $this->questionOptionService->destroy($id);
    }
}
