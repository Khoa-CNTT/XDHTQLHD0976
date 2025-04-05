<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Reset mặc định */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    /* Nền gradient */
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }

    /* Container form */
    .register-container {
      background: #fff;
      width: 100%;
      max-width: 600px;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .register-container h1 {
      text-align: center;
      font-size: 1.8rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 1rem;
    }

    .register-container .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    .register-container label {
      width: 150px; /* Chiều rộng cố định cho nhãn */
      margin-right: 1rem;
      color: #555;
      font-weight: bold;
      font-size: 0.9rem;
      text-align: right; /* Căn phải nhãn */
    }

    .register-container input {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 0.9rem;
      transition: border-color 0.3s;
    }

    .register-container input:focus {
      border-color: #667eea;
      outline: none;
    }

    .register-container button {
      width: 100%;
      padding: 0.7rem;
      background: #667eea;
      color: #fff;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .register-container button:hover {
      background: #5a67d8;
    }

    .register-container p {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #444;
    }

    .register-container a {
      color: #667eea;
      text-decoration: none;
      font-weight: bold;
    }

    .register-container a:hover {
      text-decoration: underline;
    }

    .error-messages {
      background: #ffe6e6;
      border: 1px solid #ffcccc;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border-radius: 5px;
      color: #cc0000;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h1>Đăng ký</h1>
    <!-- Hiển thị lỗi nếu có -->
    @if($errors->any())
      <div class="error-messages">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên của bạn" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="123abc@gmail.com" required>
      </div>
      <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại" required>
      </div>
      <div class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Nhập địa chỉ của bạn" required>
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
      </div>
      <!-- Các trường dành cho Customer -->
      <div class="form-group">
        <label for="company_name">Tên công ty</label>
        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Nhập tên công ty" required>
      </div>
      <div class="form-group">
        <label for="tax_code">Mã số thuế</label>
        <input type="text" id="tax_code" name="tax_code" value="{{ old('tax_code') }}" placeholder="Nhập mã số thuế" required>
      </div>
      <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
  </div>
</body>
</html>