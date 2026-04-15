<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Купить продукты',
                'description' => 'Молоко, хлеб, яйца',
                'date' => now()->addDay(),
                'completed' => false,
            ],
            [
                'title' => 'Сделать тестовое задание',
                'description' => 'Закончить Laravel проект',
                'date' => now()->addHours(5),
                'completed' => false,
            ],
            [
                'title' => 'Позвонить клиенту',
                'description' => 'Обсудить детали',
                'date' => now()->subDay(),
                'completed' => true,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
