<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Jobs\ExportUserCsvJob;
use App\Jobs\ExportUserPdfJob;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function index(array $data)
    {
        return $this->userRepository->index($data);
    }

    public function store(array $data)
    {
        return $this->userRepository->store($data);
    }

    public function show(string $id)
    {
        return $this->userRepository->show($id);
    }

    public function update(array $data, string $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function destroy(string $id)
    {
        $this->userRepository->destroy($id);
    }

    public function exportCsv(array $data): array
    {
        dispatch(new ExportUserCsvJob($this->userRepository->index($data)));

        return [
            'status' => 200,
            'message' => 'Exportando dados para o csv'
        ];
    }

    public function exportPdf(array $data): array
    {
        dispatch(new ExportUserPdfJob($this->userRepository->index($data)));

        return [
            'status' => 200,
            'message' => 'Exportando dados para o pdf'
        ];
    }

    public function login(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            abort(403, 'Erro ao fazer login. Tente novamente!');
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }
}
