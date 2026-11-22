<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], ['name' => 'Demo Administrator', 'password' => Hash::make('password')]);
        Task::insert([
            ['title'=>'Prepare assessment documentation','description'=>'Complete the TSA4 project documentation and README.','due_date'=>now()->addDays(2),'priority'=>'high','status'=>'pending','is_archived'=>false,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Review Laravel validation','description'=>'Check all task form validation rules.','due_date'=>now()->addDays(4),'priority'=>'medium','status'=>'in_progress','is_archived'=>false,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Create first test task','description'=>'Sample completed task for notification testing.','due_date'=>now(),'priority'=>'low','status'=>'done','is_archived'=>false,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
