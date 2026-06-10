<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $dept = Department::create([
            'name' => 'IT Department'
        ]);

        Employee::create([
            'name' => 'test',
            'email' => 'test@sample.com',
            'position' => 'Admin',
            'department_id' => $dept->id
        ]);
    }
}