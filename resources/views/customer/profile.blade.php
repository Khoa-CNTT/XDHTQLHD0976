@extends('layouts.customer')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('info')" id="info-tab" class="border-purple-500 text-purple-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Thông tin cá nhân
                        </button>
                        <button onclick="showTab('password')" id="password-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Đổi mật khẩu
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Contents -->
            <div id="info-content">
                <!-- Avatar và thông tin tài khoản -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <img src="{{ $user->getAvatarUrl() }}" alt="Avatar" class="w-28 h-28 rounded-full shadow mb-4 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <button type="button" onclick="document.getElementById('avatar-upload').click()" class="bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <form id="avatar-form" action="{{ route('customer.profile.update-avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" name="avatar" id="avatar-upload" class="hidden" onchange="document.getElementById('avatar-form').submit()">
                    </form>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-1">{{ $user->email }}</p>
                    <p class="text-gray-600">{{ $customer->company_name }} | MST: {{ $customer->tax_code }}</p>
                </div>

                <!-- Thông tin cơ bản và Form cập nhật -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Thông tin tài khoản</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Họ và tên</label>
                                <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email</label>
                                <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Tên công ty</label>
                                <p class="mt-1 text-gray-900">{{ $customer->company_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Mã số thuế</label>
                                <p class="mt-1 text-gray-900">{{ $customer->tax_code }}</p>
                            </div>
                            <div>
    <label class="block text-sm font-medium text-gray-600">Căn cước công dân</label>
        <p class="mt-1 text-gray-900">{{ $user->identity_card }}</p>
</div>
<div>
    <label class="block text-sm font-medium text-gray-600">Năm sinh</label>
      <p class="mt-1 text-gray-900">{{ $user->dob }}</p>
</div>
                        </div>
                    </div>

                    <!-- Form cập nhật thông tin -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Cập nhật thông tin liên hệ</h3>
                        
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-600">Số điện thoại <span class="text-red-500">*</span></label>
                                    <input type="text" id="phone" name="phone" 
                                        class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-purple-600 @error('phone') border-red-500 @enderror" 
                                        value="{{ old('phone', $user->phone) }}" required placeholder="Nhập số điện thoại (10 số)">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-600">Địa chỉ <span class="text-red-500">*</span></label>
                                    <input type="text" id="address" name="address" 
                                        class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-purple-600 @error('address') border-red-500 @enderror" 
                                        value="{{ old('address', $user->address) }}" required placeholder="Nhập địa chỉ (ít nhất 5 ký tự)">
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" 
                                    class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition duration-300">
                                    Cập nhật thông tin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Thông báo cá nhân -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Thông báo cá nhân</h3>
                        @if($notifications->count() > 0)
                            <a href="{{ route('customer.notifications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        @if($notifications->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($notifications->take(2) as $noti)
                                    <li class="py-4 {{ $noti->is_read ? 'bg-white' : 'bg-blue-50' }} rounded-lg px-4 {{ !$loop->first ? 'mt-2' : '' }}">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-800">{{ $noti->title }}</div>
                                                <div class="text-gray-600 text-sm">{{ Str::limit($noti->message, 80) }}</div>
                                            </div>
                                            <div class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                                {{ $noti->created_at instanceof \Carbon\Carbon ? $noti->created_at->diffForHumans() : $noti->created_at }}
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('customer.notifications.show', $noti->id) }}" class="text-blue-600 hover:text-blue-800 text-sm inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Xem chi tiết
                                            </a>
                                            @if(!$noti->is_read)
                                                <span class="inline-block ml-3 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                    Chưa đọc
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="p-4 text-gray-500 text-center">Không có thông báo nào</p>
                        @endif
                    </div>
                </div>

                <!-- Lịch sử hoạt động -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Lịch sử hoạt động</h3>
                        @if($activities->count() > 0)
                            <button type="button" id="show-more-activities" class="text-blue-600 text-sm hover:text-blue-800 font-medium">
                                Xem thêm
                            </button>
                        @endif
                    </div>
                    <div class="bg-white rounded-lg shadow">
                        @if($activities->count() > 0)
                            <ul class="p-4 space-y-3">
                                @foreach($activities->take(2) as $log)
                                    <li class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $log->action }}</div>
                                                <div class="text-gray-600 text-sm line-clamp-1">{{ $log->description }}</div>
                                            </div>
                                            <div class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                                {{ $log->created_at instanceof \Carbon\Carbon ? $log->created_at->diffForHumans() : $log->created_at }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <!-- Modal hoạt động -->
                            <div id="activities-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                                <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[80vh] overflow-auto">
                                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-gray-800">Lịch sử hoạt động</h3>
                                        <button id="close-activities-modal" class="text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <div id="activities-pages">
                                            @php
                                                $totalPages = ceil($activities->count() / 7);
                                                $currentActivitiesPage = 1;
                                            @endphp
                                            
                                            @for ($page = 1; $page <= $totalPages; $page++)
                                                <div class="activities-page {{ $page == 1 ? '' : 'hidden' }}" data-page="{{ $page }}">
                                                    <ul class="divide-y divide-gray-200">
                                                        @foreach($activities->forPage($page, 7) as $log)
                                                            <li class="py-3">
                                                                <div class="flex justify-between items-start p-2">
                                                                    <div>
                                                                        <div class="font-medium text-gray-800">{{ $log->action }}</div>
                                                                        <div class="text-gray-600 text-sm">{{ $log->description }}</div>
                                                                    </div>
                                                                    <div class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                                                        {{ $log->created_at instanceof \Carbon\Carbon ? $log->created_at->format('d/m/Y H:i') : $log->created_at }}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endfor
                                            
                                            @if($totalPages > 1)
                                                <div class="flex justify-center items-center mt-4 pt-3 border-t border-gray-200">
                                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                                        <button id="prev-activities-page" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                                            <span class="sr-only">Trước</span>
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        
                                                        @for ($i = 1; $i <= $totalPages; $i++)
                                                            <button type="button" data-page="{{ $i }}" 
                                                                class="activities-page-btn relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium {{ $i == 1 ? 'bg-blue-50 text-blue-600 z-10' : 'text-gray-500 hover:bg-gray-50' }}">
                                                                {{ $i }}
                                                            </button>
                                                        @endfor
                                                        
                                                        <button id="next-activities-page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ $totalPages <= 1 ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}" {{ $totalPages <= 1 ? 'disabled' : '' }}>
                                                            <span class="sr-only">Sau</span>
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </nav>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="p-4 text-gray-500 text-center">Chưa có hoạt động nào</p>
                            
                            <!-- Khai báo biến totalPages ngay cả khi không có hoạt động -->
                            @php
                                $totalPages = 0;
                                $currentActivitiesPage = 1;
                            @endphp
                        @endif
                    </div>
                </div>


                <!-- Yêu cầu hỗ trợ -->
                <div class="mb-8 bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Yêu cầu hỗ trợ gần đây</h3>
                        <a href="{{ route('customer.support.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if($supportTickets->count() > 0)
                        @php
                            $latestTicket = $supportTickets->first();
                        @endphp
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $latestTicket->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($latestTicket->content, 120) }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium
                                        @switch($latestTicket->status)
                                            @case('Chờ xử lý')
                                                bg-yellow-100 text-yellow-800
                                                @break
                                            @case('Đang xử lý')
                                                bg-blue-100 text-blue-800
                                                @break
                                            @case('Đã giải quyết')
                                                bg-green-100 text-green-800
                                                @break
                                            @case('Đã huỷ')
                                                bg-red-100 text-red-800
                                                @break
                                            @default
                                                bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ $latestTicket->status }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $latestTicket->created_at instanceof \Carbon\Carbon ? $latestTicket->created_at->format('d/m/Y H:i') : $latestTicket->created_at }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3 flex justify-between items-center">
                                <div>
                                    @if($latestTicket->responses->count() > 0)
                                        <span class="text-sm text-blue-500">{{ $latestTicket->responses->count() }} phản hồi</span>
                                        @if($latestTicket->hasStaffResponse())
                                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">Đã có phản hồi</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500">Chưa có phản hồi</span>
                                    @endif
                                </div>
                                <a href="{{ route('customer.support.show', $latestTicket->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Chi tiết <i class="fas fa-eye ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600 mb-2">Bạn chưa có yêu cầu hỗ trợ nào</p>
                            <button onclick="openSupportModal()" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i> Tạo yêu cầu mới
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Đổi mật khẩu Tab -->
            <div id="password-content" class="hidden">
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Đổi mật khẩu</h2>
                    <form action="{{ route('customer.profile.change-password') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="old_password" class="block text-sm font-medium text-gray-600">Mật khẩu hiện tại <span class="text-red-500">*</span></label>
                                <input type="password" id="old_password" name="old_password" 
                                    class="mt-1 w-full p-3 border rounded-md focus:ring-2 focus:ring-purple-600 @error('old_password') border-red-500 @enderror" required>
                                @error('old_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-600">Mật khẩu mới <span class="text-red-500">*</span></label>
                                <input type="password" id="new_password" name="new_password" 
                                    class="mt-1 w-full p-3 border rounded-md focus:ring-2 focus:ring-purple-600 @error('new_password') border-red-500 @enderror" required>
                                @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                <div class="mt-2 bg-gray-50 p-3 rounded-md border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Mật khẩu phải có:</p>
                                    <ul class="text-xs text-gray-600 space-y-1 ml-5 list-disc">
                                        <li>Ít nhất 8 ký tự</li>
                                        <li>Ít nhất 1 chữ cái viết hoa (A-Z)</li>
                                        <li>Ít nhất 1 chữ cái viết thường (a-z)</li>
                                        <li>Ít nhất 1 chữ số (0-9)</li>
                                        <li>Ít nhất 1 ký tự đặc biệt (@$!%*#?&)</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-600">Xác nhận mật khẩu mới <span class="text-red-500">*</span></label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                    class="mt-1 w-full p-3 border rounded-md focus:ring-2 focus:ring-purple-600" required>
                            </div>

                            <button type="submit" 
                                class="w-full bg-purple-600 text-white py-3 px-4 rounded-md hover:bg-purple-700 transition duration-300 text-lg">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<!-- Modal gửi yêu cầu hỗ trợ -->
<div id="supportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Tạo yêu cầu hỗ trợ mới</h3>
            <button onclick="closeSupportModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('customer.support.create') }}" method="POST" class="px-6 py-4">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
                <input type="text" id="title" name="title" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tiêu đề yêu cầu hỗ trợ">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
                <textarea id="content" name="content" rows="5" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Mô tả chi tiết vấn đề bạn đang gặp phải..."></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeSupportModal()" class="mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200">
                    Huỷ bỏ
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                    Gửi yêu cầu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tab) {
    const infoTab = document.getElementById('info-tab');
    const passwordTab = document.getElementById('password-tab');
    const infoContent = document.getElementById('info-content');
    const passwordContent = document.getElementById('password-content');

    if (tab === 'info') {
        infoTab.classList.add('border-purple-500', 'text-purple-600');
        infoTab.classList.remove('border-transparent', 'text-gray-500');
        passwordTab.classList.add('border-transparent', 'text-gray-500');
        passwordTab.classList.remove('border-purple-500', 'text-purple-600');

        infoContent.classList.remove('hidden');
        passwordContent.classList.add('hidden');
    } else {
        passwordTab.classList.add('border-purple-500', 'text-purple-600');
        passwordTab.classList.remove('border-transparent', 'text-gray-500');
        infoTab.classList.add('border-transparent', 'text-gray-500');
        infoTab.classList.remove('border-purple-500', 'text-purple-600');

        passwordContent.classList.remove('hidden');
        infoContent.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('tab') === 'password')
        showTab('password');
    @else
        showTab('info');
    @endif
    
    // Hiển thị thông báo popup nếu có
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#9f7aea',
            timer: 3000
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#9f7aea'
        });
    @endif
    
    // Thông báo khi thay đổi ảnh đại diện
    document.getElementById('avatar-upload').addEventListener('change', function() {
        Swal.fire({
            icon: 'info',
            title: 'Đang cập nhật...',
            text: 'Ảnh đại diện đang được cập nhật, vui lòng đợi.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        // Form sẽ tự động submit khi có sự thay đổi
    });
    
    // Xử lý modal lịch sử hoạt động
    const showMoreActivitiesBtn = document.getElementById('show-more-activities');
    const activitiesModal = document.getElementById('activities-modal');
    const closeActivitiesModalBtn = document.getElementById('close-activities-modal');
    
    if (showMoreActivitiesBtn) {
        showMoreActivitiesBtn.addEventListener('click', function() {
            activitiesModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Ngăn cuộn trang khi modal hiển thị
        });
    }
    
    if (closeActivitiesModalBtn) {
        closeActivitiesModalBtn.addEventListener('click', function() {
            activitiesModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Cho phép cuộn trang trở lại
        });
    }
    
    // Đóng modal khi click ra ngoài
    if (activitiesModal) {
        activitiesModal.addEventListener('click', function(event) {
            if (event.target === activitiesModal) {
                activitiesModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    // Xử lý phân trang cho lịch sử hoạt động
    let currentActivitiesPage = 1;
    const totalActivitiesPages = {{ $totalPages ?? 0 }}; // Đảm bảo có giá trị mặc định nếu không có biến
    
    // Các nút phân trang
    const pageButtons = document.querySelectorAll('.activities-page-btn');
    const prevPageBtn = document.getElementById('prev-activities-page');
    const nextPageBtn = document.getElementById('next-activities-page');
    
    // Hàm chuyển trang
    function goToActivitiesPage(page) {
        // Ẩn tất cả các trang
        document.querySelectorAll('.activities-page').forEach(pageElement => {
            pageElement.classList.add('hidden');
        });
        
        // Hiển thị trang được chọn
        const selectedPage = document.querySelector(`.activities-page[data-page="${page}"]`);
        if (selectedPage) {
            selectedPage.classList.remove('hidden');
        }
        
        // Cập nhật trạng thái nút phân trang
        pageButtons.forEach(btn => {
            const btnPage = parseInt(btn.getAttribute('data-page'));
            if (btnPage === page) {
                btn.classList.add('bg-blue-50', 'text-blue-600', 'z-10');
                btn.classList.remove('text-gray-500', 'hover:bg-gray-50');
            } else {
                btn.classList.remove('bg-blue-50', 'text-blue-600', 'z-10');
                btn.classList.add('text-gray-500', 'hover:bg-gray-50');
            }
        });
        
        // Cập nhật trạng thái nút prev/next
        prevPageBtn.disabled = page === 1;
        nextPageBtn.disabled = page === totalActivitiesPages;
        
        // Cập nhật trang hiện tại
        currentActivitiesPage = page;
    }
    
    // Xử lý sự kiện click cho các nút trang
    pageButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const page = parseInt(this.getAttribute('data-page'));
            goToActivitiesPage(page);
        });
    });
    
    // Xử lý nút prev
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', function() {
            if (currentActivitiesPage > 1) {
                goToActivitiesPage(currentActivitiesPage - 1);
            }
        });
    }
    
    // Xử lý nút next
    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', function() {
            if (currentActivitiesPage < totalActivitiesPages) {
                goToActivitiesPage(currentActivitiesPage + 1);
            }
        });
    }
    
    // Xử lý modal thông báo
    const showMoreNotificationsBtn = document.getElementById('show-more-notifications');
    const notificationsModal = document.getElementById('notifications-modal');
    const closeNotificationsModalBtn = document.getElementById('close-notifications-modal');
    
    if (showMoreNotificationsBtn) {
        showMoreNotificationsBtn.addEventListener('click', function() {
            notificationsModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (closeNotificationsModalBtn) {
        closeNotificationsModalBtn.addEventListener('click', function() {
            notificationsModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }
    
    // Đóng modal khi click ra ngoài
    if (notificationsModal) {
        notificationsModal.addEventListener('click', function(event) {
            if (event.target === notificationsModal) {
                notificationsModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }
});

function openSupportModal() {
    document.getElementById('supportModal').classList.remove('hidden');
}

function closeSupportModal() {
    document.getElementById('supportModal').classList.add('hidden');
}
</script>
@endsection
