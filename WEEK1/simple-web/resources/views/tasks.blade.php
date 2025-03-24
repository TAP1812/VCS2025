<!DOCTYPE html>
<html>
<head>
    <title>Danh sách công việc</title>
</head>
<body>
    <h1>Danh sách công việc</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task->title }} - {{ $task->description }}</li>
        @endforeach
    </ul>
</body>
</html>
