@extends('layouts.customer')
@section('title', 'Ký Hợp Đồng')
<style>
    /* Style cho phần title của accordion */
    .accordion {
        background-color: #f1f1f1;
        color: #333;
        cursor: pointer;
        padding: 15px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 18px;
        font-weight: 600;
        transition: 0.3s;
    }

    .accordion:hover {
        background-color: #ddd;
    }

    /* Style khi accordion được mở */
    .accordion.active {
        background-color: #ccc;
    }

    /* Style cho nội dung của accordion */
    .accordion-content {
        padding: 10px 15px;
        background-color: #f9f9f9;
        display: none;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.3s ease-out;
    }

    /* Style khi accordion mở ra */
    .accordion-content p {
        margin: 10px 0;
        font-size: 14px;
        color: #555;
    }
</style>
@section('content')

<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
    <h2 class="text-2xl font-semibold mb-6">Ký Hợp Đồng</h2>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
        <div class="bg-green-100 text-green-600 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Thông tin dịch vụ -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Dịch vụ: {{ $service->service_name }}</h3>
        <p class="text-gray-600">Loại dịch vụ: {{ $service->service_type }}</p>
        <p class="text-gray-600">Giá: {{ number_format($service->price, 0, ',', '.') }} VND</p>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Thông tin khách hàng</h3>
        <p class="text-gray-600">Tên: {{ Auth::user()->name }}</p>
        <p class="text-gray-600">Email: {{ Auth::user()->email }}</p>
        <p class="text-gray-600">Số điện thoại: {{ Auth::user()->phone }}</p>
        <p class="text-gray-600">Địa chỉ: {{ Auth::user()->address }}</p>
        <p class="text-gray-600">Mã số thuế: {{ Auth::user()->customer->tax_code ?? 'Chưa cập nhật' }}</p>
        <p class="text-gray-600">Thời hạn hợp đồng: 
            @php
                $durations = [
                    '6 tháng' => '6 Tháng',
                    '1 năm' => '1 Năm',
                    '3 năm' => '3 Năm'
                ];
        
                $selectedDuration = array_key_exists($duration, $durations) ? $durations[$duration] : '6 Tháng';
            @endphp
            {{ $selectedDuration }}
        </p>
        
        
    </div>

    <!-- Điều khoản hợp đồng -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Điều Khoản Hợp Đồng Cung Cấp Dịch Vụ Công Nghệ Thông Tin Điện Tử</h3>
    
        <!-- Điều khoản 1 -->
        <div class="accordion-item">
            <button class="accordion">
                Điều 1: Định Nghĩa
            </button>
            <div class="accordion-content">
                <p>
                    <strong>Dịch vụ cung cấp:</strong> Là các dịch vụ công nghệ thông tin điện tử mà bên cung cấp (sau đây gọi là "Bên A") cung cấp cho bên nhận (sau đây gọi là "Bên B"), bao gồm nhưng không giới hạn ở phát triển phần mềm, thiết kế website, hỗ trợ kỹ thuật, bảo trì hệ thống, v.v.
                </p>
                <p>
                    <strong>Sản phẩm công nghệ:</strong> Là các phần mềm, ứng dụng, hệ thống, nền tảng, giao diện, hoặc tài liệu mà Bên A cung cấp cho Bên B trong khuôn khổ hợp đồng này.
                </p>
            </div>
        </div>
    
        <!-- Điều khoản 2 -->
        <div class="accordion-item">
            <button class="accordion">
                Điều 2: Phạm Vi Dịch Vụ
            </button>
            <div class="accordion-content">
                <p>
                    <strong>Mô tả dịch vụ:</strong> Bên A sẽ cung cấp cho Bên B các dịch vụ theo yêu cầu cụ thể như đã được thống nhất trong hợp đồng này và tài liệu kèm theo.
                </p>
                <p>
                    <strong>Thời gian thực hiện:</strong> Dịch vụ sẽ được thực hiện trong thời gian đã thỏa thuận, bắt đầu từ ngày ký hợp đồng và kết thúc vào ngày hoàn thành công việc.
                </p>
                <p>
                    <strong>Phạm vi công việc:</strong> Bên A chỉ thực hiện công việc trong phạm vi đã được liệt kê trong hợp đồng. Mọi yêu cầu bổ sung sẽ được thương thảo và lập biên bản bổ sung.
                </p>
            </div>
        </div>
    
        <!-- Điều khoản 3 -->
        <div class="accordion-item">
            <button class="accordion">
                Điều 3: Giá Cả và Thanh Toán
            </button>
            <div class="accordion-content">
                <p>
                    <strong>Giá dịch vụ:</strong> Bên B sẽ thanh toán cho Bên A một khoản phí tổng cộng theo mức giá đã thỏa thuận trong hợp đồng.
                </p>
                <p>
                    <strong>Phương thức thanh toán:</strong> Thanh toán sẽ được thực hiện qua chuyển khoản ngân hàng, tiền mặt hoặc các hình thức khác mà hai bên thống nhất.
                </p>
                <p>
                    <strong>Thời gian thanh toán:</strong> Bên B sẽ thanh toán 50% giá trị hợp đồng sau khi ký kết hợp đồng, 30% khi hoàn thành 50% công việc, và 20% còn lại khi Bên A hoàn thành và bàn giao sản phẩm dịch vụ.
                </p>
            </div>
        </div>
    
        <!-- Thêm các điều khoản khác tương tự -->
    </div>
    

    <!-- Form gửi OTP -->
    <form action="{{ route('customer.contracts.sendOtp', $service->id) }}" method="POST" class="mb-6">
        @csrf
        
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Gửi OTP</button>
    </form>

    <!-- Form nhập OTP -->
    <form action="{{ route('customer.contracts.sign', $service->id) }}" method="POST">
        @csrf
        <input type="hidden" name="duration" value="{{ $duration }}">
        <div class="mb-4">
            <label for="otp" class="block mb-1 font-medium">Nhập mã OTP</label>
            <input type="text" name="otp" id="otp" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label for="identity_card" class="block mb-1 font-medium">Căn cước công dân</label>
            <input type="text" name="identity_card" id="identity_card" value="{{ Auth::user()->identity_card }}" 
                   class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label for="contract_date" class="block mb-1 font-medium">Ngày ký hợp đồng</label>
            <input type="date" name="contract_date" id="contract_date" value="{{ now()->format('Y-m-d') }}" 
                   class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="agreed_terms" value="1" class="form-checkbox text-blue-600 h-5 w-5" required>
                <span class="ml-2 text-gray-700">Tôi đồng ý với các điều khoản</span>
            </label>
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ký hợp đồng</button>
    </form>
</div>
<script>
    // Lấy tất cả các nút accordion
    const accordions = document.querySelectorAll('.accordion');

    // Thêm sự kiện click cho mỗi nút accordion
    accordions.forEach((accordion) => {
        accordion.addEventListener('click', function () {
            // Tắt tất cả các accordion khác
            accordions.forEach((acc) => {
                if (acc !== accordion) {
                    acc.classList.remove('active');
                    acc.nextElementSibling.style.maxHeight = null;
                }
            });

            // Toggling cho accordion hiện tại
            accordion.classList.toggle('active');
            const content = accordion.nextElementSibling;

            // Kiểm tra trạng thái active và điều chỉnh max-height
            if (accordion.classList.contains('active')) {
                content.style.display = 'block'; // Mở accordion
                content.style.maxHeight = content.scrollHeight + 'px'; // Tính toán chiều cao động
            } else {
                content.style.display = 'none'; // Đóng accordion
                content.style.maxHeight = null;
            }
        });
    });
</script>

@endsection