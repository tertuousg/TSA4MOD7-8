@component('mail::message')
# Task completed

The task **{{ $task->title }}** has been marked as done.

**Due date:** {{ $task->due_date->format('F d, Y') }}  
**Priority:** {{ ucfirst($task->priority) }}

{{ $task->description ?: 'No description was provided.' }}

Thanks,  
{{ config('app.name') }}
@endcomponent
