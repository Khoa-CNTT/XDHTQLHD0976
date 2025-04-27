@extends('layouts.customer')
@section('title', 'Ký Hợp Đồng')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-md border border-gray-200 space-y-8">

    <h2 class="text-3xl font-bold text-center text-black-700 mb-6">Ký Hợp Đồng</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Thông tin dịch vụ --}}
    <div class="space-y-2">
        <h3 class="text-xl font-semibold text-gray-800">Thông tin dịch vụ</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
        <p>Dịch vụ: {{ $service->service_name }}</p>
        <p>Loại dịch vụ: {{ $service->service_type }}</p>
        <p>Thời hạn hợp đồng:
            @php
                $durations = [
                    '6_thang' => '6 Tháng',
                    '1_nam' => '1 Năm',
                    '3_nam' => '3 Năm'
                ];

                // Gán lại duration đúng dạng chuẩn
                $selectedDuration = array_key_exists($duration, $durations) ? $durations[$duration] : '6 Tháng';
                
            @endphp
            {{ $selectedDuration }}
        </p>
        <p>Giá: {{ number_format($service->price, 0, ',', '.') }} VND</p>
        </div>
    </div>

    {{-- Thông tin khách hàng --}}
    <div class="space-y-2">
        <h3 class="text-xl font-semibold text-gray-800">Thông tin khách hàng</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
            <p>Tên: {{ Auth::user()->name }}</p>
            <p>Email: {{ Auth::user()->email }}</p>
            <p>Điện thoại: {{ Auth::user()->phone }}</p>
            <p>Mã số thuế: {{ Auth::user()->customer->tax_code ?? 'Chưa cập nhật' }}</p>
            <p>Địa chỉ: {{ Auth::user()->address }}</p>
        </div>
    </div>

    {{-- Điều khoản hợp đồng (Accordion) --}}
    <div class="space-y-4">
        <h3 class="text-xl font-semibold text-gray-800">Điều Khoản Hợp Đồng</h3>

        @foreach([
            ['title' => 'Điều 1: Định Nghĩa', 'content' => '
                <b>Dịch vụ cung cấp:</b> Là các dịch vụ công nghệ thông tin điện tử mà bên cung cấp (sau đây gọi là "Bên A") cung cấp cho bên nhận (sau đây gọi là "Bên B"), bao gồm nhưng không giới hạn ở phát triển phần mềm, thiết kế website, hỗ trợ kỹ thuật, bảo trì hệ thống, v.v.<br>
                <b>Sản phẩm công nghệ:</b> Là các phần mềm, ứng dụng, hệ thống, nền tảng, giao diện, hoặc tài liệu mà Bên A cung cấp cho Bên B trong khuôn khổ hợp đồng này.'],
            ['title' => 'Điều 2: Phạm Vi Dịch Vụ', 'content' => '
                <b>Mô tả dịch vụ:</b> Bên A sẽ cung cấp cho Bên B các dịch vụ theo yêu cầu cụ thể như đã được thống nhất trong hợp đồng này và tài liệu kèm theo.<br>
                <b>Thời gian thực hiện:</b> Dịch vụ sẽ được thực hiện trong thời gian đã thỏa thuận, bắt đầu từ ngày ký hợp đồng và kết thúc vào ngày hoàn thành công việc.<br>
                <b>Phạm vi công việc:</b> Bên A chỉ thực hiện công việc trong phạm vi đã được liệt kê trong hợp đồng. Mọi yêu cầu bổ sung sẽ được thương thảo và lập biên bản bổ sung.'],
            ['title' => 'Điều 3: Giá Cả và Thanh Toán', 'content' => '
                <b>Giá dịch vụ:</b> Bên B sẽ thanh toán cho Bên A một khoản phí tổng cộng theo mức giá đã thỏa thuận trong hợp đồng.<br>
                <b>Phương thức thanh toán:</b> Thanh toán sẽ được thực hiện qua chuyển khoản ngân hàng, tiền mặt hoặc các hình thức khác mà hai bên thống nhất.<br>
                <b>Thời gian thanh toán:</b> Bên B sẽ thanh toán 50% giá trị hợp đồng sau khi ký kết hợp đồng, 30% khi hoàn thành 50% công việc, và 20% còn lại khi Bên A hoàn thành và bàn giao sản phẩm dịch vụ.']
        ] as $item)
        <details class="border border-gray-300 rounded-lg p-4 mb-4">
            <summary class="font-semibold cursor-pointer text-gray-800">{{ $item['title'] }}</summary>
            <div class="mt-2 text-gray-700 leading-relaxed">
                {!! $item['content'] !!}
            </div>
        </details>
        @endforeach
    </div>

    {{-- Gửi OTP --}}
    <form action="{{ route('customer.contracts.sendOtp', $service->id) }}" method="POST" class="text-center">
        @csrf
        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-lg transition duration-300">
            Gửi Mã OTP
        </button>
    </form>

    {{-- Form ký hợp đồng --}}
    <form action="{{ route('customer.contracts.sign', $service->id) }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="duration" value="{{ $duration }}">

        <div>
            <label for="otp" class="block font-medium mb-1">Mã OTP</label>
            <input type="text" id="otp" name="otp" required
                   class="w-full border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="identity_card" class="block font-medium mb-1">Căn cước công dân</label>
            <input type="text" id="identity_card" name="identity_card" required
                   value="{{ Auth::user()->identity_card }}"
                   class="w-full border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="contract_date" class="block font-medium mb-1">Ngày ký hợp đồng</label>
            <input type="date" id="contract_date" name="contract_date" required
                   value="{{ now()->format('Y-m-d') }}"
                   class="w-full border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="agreed_terms" name="agreed_terms" value="1" required
                   class="h-5 w-5 text-blue-600">
            <label for="agreed_terms" class="text-gray-700">Tôi đồng ý với các điều khoản</label>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Ký hợp đồng
            </button>
        </div>
    </form>

</div>
@endsection
