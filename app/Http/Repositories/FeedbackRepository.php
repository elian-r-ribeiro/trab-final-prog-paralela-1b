<?php

namespace App\Http\Repositories;

use App\Models\Feedback;

class FeedbackRepository extends BaseRepository
{
    public function __construct(Feedback $model)
    {
        parent::__construct($model);
    }

    public function index(array $data)
    {

        $query = $this->model->newQuery();

        if (isset($data['quiz_id'])) {
            $query->where('quiz_id', $data['quiz_id']);
        }

        return isset($data['per_page'])
            ? $query->paginate($data['per_page'])
            : $query->get();
    }
}
