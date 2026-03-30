<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $tasks = [
             [
                'title' => 'Fix Production Server',
                'due_date' => $today,
                'priority' => 'high',
                'status' => 'in_progress',
            ],
             [
                'title' => 'Submit Internship Project',
                'due_date' => $tomorrow,
                'priority' => 'high',
                'status' => 'pending',
            ],
             [
                'title' => 'Attend Team Meeting',
                'due_date' => $today,
                'priority' => 'medium',
                'status' => 'pending',
            ],
             [
                'title' => 'Email Support Team',
                'due_date' => $today,
                'priority' => 'low',
                'status' => 'done',
            ],
             [
                'title' => 'Database Optimization',
                'due_date' => $today,
                'priority' => 'high',
                'status' => 'pending',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
        //
    }
}
