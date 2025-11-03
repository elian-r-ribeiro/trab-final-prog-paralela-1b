<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
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
        return UserResource::collection($this->userService->index($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): UserResource
    {
        $data = $request->validated();

        $data['company_id'] = auth()->user()->company_id;

        return new UserResource($this->userService->store($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UserResource($this->userService->find($id));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        return new UserResource($this->userService->update($request->validated(), $id));
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

    public function login(Request $request)
    {
        $user = $this->userService->login($request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]));

        return response()->json(['data' => $user]);
    }
}
