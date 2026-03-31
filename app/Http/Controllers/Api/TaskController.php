<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;



class TaskController extends Controller
{ public function index(Request $request)
{
    $query = Task::query();

     if ($request->has('status')) {
        $query->where('status', $request->status);
    }

     $tasks = $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC")
                   ->orderBy('due_date', 'asc')
                   ->get();

     if ($tasks->isEmpty()) {
        return response()->json(['message' => 'No tasks found.'], 200);
    }

    return response()->json($tasks);
}

     public function store(StoreTaskRequest $request)
{
    $task = Task::create($request->validated());

    return response()->json([
        'message' => 'Task created successfully',
        'data' => $task
    ], 201);
}
     public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
{
     $newStatus = $request->status;


    $this->authorize('updateStatus', [$task, $newStatus]);

    $task->update(['status' => $newStatus]);

    return response()->json($task);
}

 public function destroy(Task $task)
{
    if ($task->status !== 'done') {
        return response()->json([
            'message' => 'Only completed tasks can be deleted.'
        ], 403);
    }

    $task->delete();

    return response()->json([
        'message' => 'Task deleted successfully.'
    ]);
}
public function report(Request $request)
{
    $request->validate(['date' => 'required|date']);
    $date = $request->date;

    $tasks = Task::whereDate('due_date', $date)->get();

    $summary = [
        'high'   => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
        'medium' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
        'low'    => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
    ];

    foreach ($tasks as $task) {
        $summary[$task->priority][$task->status]++;
    }

    return response()->json([
        'date' => $date,
        'summary' => $summary
    ]);
}
}
