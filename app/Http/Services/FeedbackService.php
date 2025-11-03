<?php

namespace App\Http\Services;

use App\Http\Repositories\FeedbackRepository;
use Illuminate\Http\Request;

class FeedbackService extends BaseService
{
    public function __construct(private readonly FeedbackRepository $feedbackRepository)
    {
        parent::__construct($feedbackRepository);
    }

    public function index(array $data)
    {
        return $this->feedbackRepository->index($data);
    }
}
