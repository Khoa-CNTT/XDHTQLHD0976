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
                    
                    <form id="avatar-form" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                        <input type="hidden" name="address" value="{{ $user->address }}">
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
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Thông báo cá nhân</h3>
                    <div class="bg-white rounded-lg shadow">
                        @if($notifications->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($notifications as $noti)
                                    <li class="p-4 {{ $noti->is_read ? 'bg-gray-50' : 'bg-blue-50' }}">
                                        <div class="font-medium text-gray-800">{{ $noti->title }}</div>
                                        <div class="text-gray-600 text-sm">{{ $noti->message }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $noti->created_at instanceof \Carbon\Carbon ? $noti->created_at->format('d/m/Y H:i') : $noti->created_at }}</div>
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
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Lịch sử hoạt động</h3>
                    <div class="bg-white rounded-lg shadow">
                        @if($activities->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($activities->take(5) as $log)
                                    <li class="p-4">
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
                            
                            @if($activities->count() > 5)
                                <div class="p-4 text-center">
                                    <button type="button" id="show-more-activities" class="text-purple-600 text-sm hover:text-purple-800 font-medium">
                                        Xem thêm lịch sử
                                    </button>
                                </div>
                                
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
                                            <ul class="divide-y divide-gray-200">
                                                @foreach($activities as $log)
                                                    <li class="py-3">
                                                        <div class="flex justify-between items-start">
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
                                    </div>
                                </div>
                            @endif
                        @else
                            <p class="p-4 text-gray-500 text-center">Chưa có hoạt động nào</p>
                        @endif
                    </div>
                </div>


                <!-- Yêu cầu hỗ trợ -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Yêu cầu hỗ trợ</h3>
                    <div class="bg-white rounded-lg shadow mb-4">
                        @if($supportTickets->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($supportTickets as $ticket)
                                    <li class="p-4">
                                        <div class="font-medium text-gray-800">{{ $ticket->title }}</div>
                                        <div class="text-gray-600 text-sm line-clamp-2">{{ $ticket->content }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $ticket->created_at instanceof \Carbon\Carbon ? $ticket->created_at->format('d/m/Y H:i') : $ticket->created_at }} | Trạng thái: <span class="font-semibold">{{ $ticket->status }}</span></div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="p-4 text-gray-500 text-center">Chưa có yêu cầu hỗ trợ nào</p>
                        @endif
                    </div>
                    <!-- Form gửi yêu cầu hỗ trợ -->
                    <form action="{{ route('customer.support.create') }}" method="POST" class="bg-white rounded-lg shadow p-4">
                        @csrf
                        <div class="mb-3">
                            <label for="support_title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                            <input type="text" id="support_title" name="title" class="w-full p-2 border rounded-md" required>
                        </div>
                        <div class="mb-3">
                            <label for="support_content" class="block text-sm font-medium text-gray-700">Nội dung</label>
                            <textarea id="support_content" name="content" rows="3" class="w-full p-2 border rounded-md" required></textarea>
                        </div>
                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Gửi yêu cầu hỗ trợ</button>
                    </form>
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
});
</script>
@endsection
