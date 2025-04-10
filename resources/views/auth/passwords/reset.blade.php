@extends('layouts.customer')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Đặt lại mật khẩu</h2>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
        
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Nhập lại mật khẩu</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Đặt lại mật khẩu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
