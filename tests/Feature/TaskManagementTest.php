<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_tasks_but_cannot_create(): void
    {
        $this->get('/tasks')->assertOk();
        $this->get('/tasks/create')->assertRedirect('/login');
    }

    public function test_marking_a_task_done_sends_one_email(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $task = Task::factory()->create(['status' => 'pending']);
        $this->actingAs($user)->put("/tasks/{$task->id}", $task->toArray() + ['status' => 'done'])->assertRedirect('/tasks');
        Mail::assertSent(\App\Mail\TaskCompleted::class, 1);
        $this->actingAs($user)->put("/tasks/{$task->id}", $task->fresh()->toArray() + ['status' => 'done']);
        Mail::assertSent(\App\Mail\TaskCompleted::class, 1);
    }
}
