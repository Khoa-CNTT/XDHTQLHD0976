@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Cài đặt hệ thống</h2>

    <div class="tabs flex space-x-4 mb-4">
        <a href="{{ route('admin.settings', ['tab' => 'general']) }}" class="{{ $tab == 'general' ? 'font-bold' : '' }}">Cấu hình chung</a>
        <a href="{{ route('admin.settings', ['tab' => 'backup']) }}" class="{{ $tab == 'backup' ? 'font-bold' : '' }}">Sao lưu & Khôi phục</a>
        <a href="{{ route('admin.settings', ['tab' => 'roles']) }}" class="{{ $tab == 'roles' ? 'font-bold' : '' }}">Vai trò</a>
        <a href="{{ route('admin.settings', ['tab' => 'logs']) }}" class="{{ $tab == 'logs' ? 'font-bold' : '' }}">Nhật ký</a>
    </div>

    <div>
        @if($tab == 'general')
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="system_name" class="block">Tên hệ thống:</label>
                    <input type="text" name="system_name" value="{{ $settings['system_name'] }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="contact_email" class="block">Email liên hệ:</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label for="logo" class="block">Logo hiện tại:</label>
                    @if(config('app.logo'))
                        <img src="{{ asset(config('app.logo')) }}" alt="Logo" class="w-32 h-32 mb-4">
                    @else
                        <p>Chưa có logo nào được tải lên.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="logo" class="block">Tải lên logo mới:</label>
                    <input type="file" name="logo" class="w-full">
                </div>


                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Lưu</button>
                </div>
            </form>
        @elseif($tab == 'backup')
            <h3 class="text-lg font-bold">Sao lưu & Khôi phục</h3>
        @elseif($tab == 'roles')
            <h3 class="text-lg font-bold">Vai trò</h3>
        @elseif($tab == 'logs')
            <h3 class="text-lg font-bold">Nhật ký</h3>
        @endif
    </div>
</div>
@endsection
