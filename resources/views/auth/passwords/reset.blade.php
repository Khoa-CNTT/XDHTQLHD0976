@extends('layouts.customer')
<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label>Mật khẩu mới</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Nhập lại mật khẩu mới</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Đặt lại mật khẩu</button>
</form>
