<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Http\Resources\QuizResource;
use App\Http\Services\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(private readonly QuizService $quizService) {}

    public function index(Request $request)
    {
        return QuizResource::collection($this->quizService->index($request->all()));
    }

    public function store(CreateQuizRequest $request): JsonResponse
    {

        $data = $request->validated();

        return response()->json([
            'message' => 'Questão criada com sucesso.',
            'data' =>  new QuizResource($this->quizService->store($data))
        ], 201);
    }

    public function update(UpdateQuizRequest $request, string $id)
    {
        return response()->json(['data' => $this->quizService->update($request->validated(), $id)]);
    }

    public function show(string $id)
    {
        return new QuizResource($this->quizService->show($id));
    }

    public function destroy(string $id)
    {
        return $this->quizService->destroy($id);
    }
}
