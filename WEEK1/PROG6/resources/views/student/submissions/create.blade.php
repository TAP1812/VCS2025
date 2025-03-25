<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp bài</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .content h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nộp bài</h1>
        </div>
        <div class="content">
            <h2>Nộp bài tập</h2>
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="assignment">Chọn bài tập</label>
                    <select id="assignment" name="assignment" required>
                        <option value="">Chọn bài tập</option>
                        <!-- Sẽ hiển thị danh sách bài tập sau -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Upload bài làm</label>
                    <input type="file" id="file" name="file" required>
                </div>
                <div class="form-group">
                    <button type="submit">Nộp bài</button>
                </div>
            </form>
            <a href="{{ route('dashboard') }}" class="back-link">Quay lại Dashboard</a>
        </div>
    </div>
</body>
</html>