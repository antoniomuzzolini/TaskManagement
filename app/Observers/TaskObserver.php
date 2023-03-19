<?php

namespace App\Observers;

use App\Models\Task;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskStatusChanged;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        // if developer is specified, then the task has been assigned on creation
        if($task->developer_id)
            $task->developer->notify(new TaskAssigned($task));
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if($task->isDirty('developer_id') && $task->developer_id)
            $task->developer->notify(new TaskAssigned($task));
        if($task->isDirty('status') && $task->status == 'done')
            $task->project->project_manager->notify(new TaskStatusChanged($task));
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
