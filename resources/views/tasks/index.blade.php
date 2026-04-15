<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таск-менеджер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Мои задачи</h1>

    <!-- Кнопка добавления -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#taskModal" id="addTaskBtn">
        + Новая задача
    </button>

    <!-- Таблица задач -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Дедлайн</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="tasksTable">
            @foreach ($tasks as $task)
            <tr id="" class="">
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->date }}</td>
                <td>
                    <input type="checkbox" @if($task->completed) checked @endif class="task-complete" data-id="{{ $task->id }}">
                </td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Изменить</a>
                    <button class="btn btn-sm btn-danger delete-task" data-id="{{ $task->id }}">Удалить</button>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Модальное окно (добавление/редактирование) -->
<div class="modal fade" id="taskModal" tabindex="-1">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Задача</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="taskId">
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата и время</label>
                        <input type="datetime-local" name="date" id="date" class="form-control" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary" id="saveTaskBtn">Сохранить</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            if (confirm('Удалить задачу?')) {
                fetch(`/tasks/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                    }
                })
                .catch(error => console.log('Ошибка:', error));
            }
        }); 
    });

    document.querySelectorAll('.task-complete').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const id = this.dataset.id;
            fetch(`/tasks/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = this.closest('tr');
                    if (data.completed) {
                        row.classList.add('table-success');
                    } else{
                        row.classList.remove('table-success');
                    }
                } 
            })
            .catch(error => console.log('Ошибка:', error));
        })
    })
</script>
</body>
</html>