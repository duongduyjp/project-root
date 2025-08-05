<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error-list {
            background-color: #ffebee;
            border: 1px solid #f44336;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            color: #c62828;
        }
        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Đăng ký</h1>
        
        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập họ tên của bạn">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn">
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu (ít nhất 6 ký tự)">
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu:</label>
                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit">Đăng ký</button>
        </form>
    </div>
</body>
</html> 