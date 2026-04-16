<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование задачи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Редактирование задачи</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Дата и время</label>
            <input type="datetime-local" name="date" class="form-control" value="{{ old('date', \Carbon\Carbon::parse($task->date)->format('Y-m-d\TH:i')) }}" required>
        </div>

        {{-- <div class="mb-3 form-check">
            <input type="checkbox" name="completed" class="form-check-input" id="completed" @if($task->completed) checked @endif value="1">
            <label class="form-check-label" for="completed">Выполнена</label>
        </div> --}}

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
</body>
</html>
