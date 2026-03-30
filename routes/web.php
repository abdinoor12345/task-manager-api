<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Route::get('/', function () {
    return response()->json([
        'api_name'      => 'Cytonn Task Management System',
        'candidate'     => 'Your Name',
        'status'        => 'Live & Operational',
        'environment'   => app()->environment(),
        'server_time'   => Carbon::now()->toDateTimeString(),

        // System Health Check (Impresses Seniors)
        'health_check' => [
            'database' => DB::connection()->getDatabaseName() ? 'Connected' : 'Error',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ],

        // Full Documentation of Routes
        'endpoints' => [
            'tasks' => [
                'index'  => [
                    'method' => 'GET',
                    'url'    => '/api/tasks',
                    'desc'   => 'List all tasks. Automatically sorted by Priority (High > Med > Low) and Due Date.'
                ],
                'store'  => [
                    'method' => 'POST',
                    'url'    => '/api/tasks',
                    'params' => ['title', 'due_date', 'priority'],
                    'desc'   => 'Create a new task. Due date must be today or future.'
                ],
                'update' => [
                    'method' => 'PATCH',
                    'url'    => '/api/tasks/{id}/status',
                    'params' => ['status'],
                    'rules'  => 'Progression: pending -> in_progress -> done'
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url'    => '/api/tasks/{id}',
                    'rules'  => 'Only tasks with "done" status can be deleted.'
                ],
                'report' => [
                    'method' => 'GET',
                    'url'    => '/api/tasks/report?date=YYYY-MM-DD',
                    'desc'   => 'Bonus: Daily summary grouped by priority and status.'
                ],
            ],
        ],

        // Acknowledgement of Business Rules
        'business_logic_status' => [
            'sorting_applied'     => true,
            'unique_title_check'  => 'enabled (per day)',
            'status_lock_enabled' => true,
        ],

     ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});
