<?php

namespace App\Services\Task;

use App\Contracts\Task\TaskRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class searchTaskService.
 */
class SearchTaskService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->search('name', 'LIKE', "%{$this->data}%")
                ->orWhere('description', 'LIKE', "%{$this->data}%")
                ->orWhere('note', 'LIKE', "%{$this->data}%")
                ->get();
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
