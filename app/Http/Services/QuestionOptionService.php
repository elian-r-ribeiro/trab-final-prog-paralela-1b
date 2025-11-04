<?php

namespace App\Http\Services;

use App\Http\Repositories\QuestionOptionRepository;
use App\Http\Repositories\QuizRepository;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Validation\ValidationException;

class QuestionOptionService extends BaseService
{
    public function __construct(
        private readonly QuestionOptionRepository $questionOptionRepository,
        private readonly QuizRepository $quizRepository
    ) {
        parent::__construct($questionOptionRepository);
    }

    public function index(array $data)
    {
        return $this->questionOptionRepository->index($data);
    }

    public function store(array $data)
    {
        $quiz = $this->quizRepository->find($data['quiz_id']);

        $this->validateQuizIsChoice($quiz);
        $this->validateSingleCorrectOption($data);

        return $this->questionOptionRepository->store($data);
    }

    public function update(array $data, string $id)
    {
        $option = $this->questionOptionRepository->find($id);
        $quiz = $option->quiz;

        if (isset($data['quiz_id'])) {
            $quiz = $this->quizRepository->find($data['quiz_id']);
        }

        $this->validateQuizIsChoice($quiz);
        $this->validateSingleCorrectOption($data, $id);

        return $this->questionOptionRepository->update($data, $id);
    }

    private function validateQuizIsChoice(Quiz $quiz): void
    {
        if ($quiz->type !== 'choice') {
            throw ValidationException::withMessages([
                'quiz_id' => 'Não é possível adicionar ou editar opções, pois a questão não é de múltiplas escolhas.',
            ]);
        }
    }

    private function validateSingleCorrectOption(array $data, ?string $id = null): void
    {
        if (!isset($data['is_correct']) || $data['is_correct'] !== true) {
            return;
        }

        $query = QuestionOption::where('quiz_id', $data['quiz_id'])
            ->where('is_correct', true);

        if ($id) {
            $query->where('id', '!=', $id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'is_correct' => 'Já existe uma opção correta para esta questão.',
            ]);
        }
    }
}
