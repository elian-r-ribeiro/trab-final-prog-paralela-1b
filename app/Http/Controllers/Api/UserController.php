<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(['data' => $this->userService->index($request->all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Usuário criado com sucesso.',
            'data' => $this->userService->store($request->validated())
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['data' => $this->userService->show($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        return response()->json(['data' => $this->userService->update($request->validated(), $id)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->destroy($id);

        return response()->noContent();
    }

    public function exportCsv(Request $request)
    {
        $response = $this->userService->exportCsv($request->all());

        return response()->json(['message' => $response['message']], $response['status']);
    }

    public function exportPdf(Request $request)
    {
        $response = $this->userService->exportPdf($request->all());

        return response()->json(['message' => $response['message']], $response['status']);
    }

    public function login(Request $request)
    {
        $user = $this->userService->login($request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]));

        return response()->json(['data' => $user]);
    }
}
