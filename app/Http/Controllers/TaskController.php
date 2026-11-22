<?php

namespace App\Http\Controllers;

use App\Mail\TaskCompleted;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::active()->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();
        return view('tasks.index', compact('tasks'));
    }

    public function create() { return view('tasks.create'); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task) { abort_if($task->is_archived, 404); return view('tasks.show', compact('task')); }

    public function edit(Task $task) { abort_if($task->is_archived, 404); return view('tasks.edit', compact('task')); }

    public function update(Request $request, Task $task)
    {
        abort_if($task->is_archived, 404);
        $wasDone = $task->status === 'done';
        $data = $this->validated($request);
        $task->update($data);

        if (!$wasDone && $task->status === 'done') {
            Mail::to(config('mail.task_notification_email'))->send(new TaskCompleted($task));
        }
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->update(['is_archived' => true]);
        return redirect()->route('tasks.index')->with('success', 'Task archived successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,done'],
        ]);
    }
}
