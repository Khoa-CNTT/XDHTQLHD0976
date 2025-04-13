<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Thiết lập font và reset một số margin */
    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      height: 100%;
    }
    /* Nền gradient cho toàn bộ trang */
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    /* Container cho form đăng nhập */
    .login-container {
      background: #fff;
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      animation: fadeIn 1s ease-in-out;
    }
    /* Hiệu ứng fadeIn */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .login-container h1 {
      text-align: center;
      font-size: 2rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 1.5rem;
    }
    .login-container label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
    }
    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }
    .login-container input[type="email"]:focus,
    .login-container input[type="password"]:focus {
      border-color: #667eea;
      outline: none;
    }
    .checkbox-group {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }
    .checkbox-group input {
      margin-right: 0.5rem;
    }
    .login-container button {
      width: 100%;
      padding: 0.75rem;
      background: #667eea;
      color: #fff;
      font-size: 1.1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .login-container button:hover {
      background: #5a67d8;
    }
    .login-container p {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.95rem;
      color: #444;
    }
    .login-container a {
      color: #667eea;
      text-decoration: none;
      font-weight: bold;
      transition: text-decoration 0.3s;
    }
    .login-container a:hover {
      text-decoration: underline;
    }
    .error-messages {
      background: #ffe6e6;
      border: 1px solid #ffcccc;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border-radius: 5px;
      color: #cc0000;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h1>Đăng nhập</h1>
    <!-- Hiển thị lỗi nếu có -->
    @if($errors->any())
      <div class="error-messages">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
          <label for="email">Email</label>
          <input 
              type="email" 
              name="email" 
              id="email" 
              value="{{ old('email') ?? request()->cookie('remember_email') }}" 
              required>
      </div>
      
      <div>
          <label for="password">Mật khẩu</label>
          <input 
              type="password" 
              name="password" 
              id="password" 
              value="{{ request()->cookie('remember_password') }}" 
              required>
      </div>
      
      <div class="checkbox-group">
          <input 
              type="checkbox" 
              name="remember_credentials" 
              id="remember_credentials"
              {{ request()->cookie('remember_email') ? 'checked' : '' }}>
          <label for="remember_credentials">Ghi nhớ đăng nhập</label>
      </div>
      <button type="submit">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
    <p> <a href="{{ route('password.request') }}">Quên mật khẩu?</a></p>
  </div>
  
</body>
</html>



