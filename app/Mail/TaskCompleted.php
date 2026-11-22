<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TaskCompleted extends Mailable
{
    use Queueable;
    public function __construct(public Task $task) {}
    public function envelope(): Envelope { return new Envelope(subject: 'Task completed: '.$this->task->title); }
    public function content(): Content { return new Content(markdown: 'emails.task-completed'); }
}
