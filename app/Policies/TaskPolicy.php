<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Task $task): Response
{
    // If the task status is 'done', allow deletion.
    if ($task->status === 'done') {
        return Response::allow();
    }

     return Response::deny('Only done tasks can be deleted.', 403);
}
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }


    public function updateStatus(?User $user, Task $task, string $newStatus): Response
    {
        $currentStatus = $task->status;

        $allowedTransitions = [
            'pending' => ['in_progress'],
            'in_progress' => ['done'],
            'done' => [], // Cannot move from done
        ];

        if (in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return Response::allow();
        }

        return Response::deny('Status progression must be: pending -> in_progress -> done. No skipping or reverting allowed.');
    }
}
