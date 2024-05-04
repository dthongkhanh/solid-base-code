<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Mail\SendEmailNotificationPastDue;
use App\Repositories\Task\TaskRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tasksPastDue = resolve(TaskRepository::class)->search('time_due', '<=', now())
            ->where('status', '!=', Status::COMPLETED)
            ->get();
        foreach ($tasksPastDue as $task) {
            $email = new SendEmailNotificationPastDue($task);
            Mail::to('dthongkhanh192@gmail.com')->send($email);
        }
    }
}
