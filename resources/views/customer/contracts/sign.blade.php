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
        <p>Loại dịch vụ: {{ $service->category->name ?? 'Không xác định' }}</p>
        <p>Thời hạn hợp đồng: {{ $durationInfo->duration->label }}</p>
        <p>Giá: {{ number_format($durationInfo->price, 0, ',', '.') }} VND</p>
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

    {{-- Signature Pad --}}
    <div class="space-y-4">
        <h3 class="text-xl font-semibold text-gray-800">Chữ Ký Tay</h3>
        <canvas id="signature-pad" width="900" height="350" class="border border-gray-300 rounded-lg w-full" style="height:350px;"></canvas>
        <div class="flex space-x-4 mt-2">
            <button type="button" id="clear-signature" class="bg-red-500 text-white px-4 py-2 rounded">Xóa chữ ký</button>
            <button type="button" id="save-signature" class="bg-blue-500 text-white px-4 py-2 rounded hidden">Lưu chữ ký</button>
        </div>
    </div>

    {{-- Gửi OTP --}}
    <form action="{{ route('customer.contracts.sendOtp', $service->id) }}" method="POST" class="text-center">
        @csrf
        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded-lg transition duration-300">
            Gửi Mã OTP
        </button>
    </form>

    {{-- Form ký hợp đồng --}}
    <form action="{{ route('customer.contracts.sign.submit', $service->id) }}" method="POST" class="space-y-6 contract-sign-form">
        @csrf
        <input type="hidden" id="signature-data" name="signature_data">
        <input type="hidden" name="duration" value="{{ $duration }}">
        <input type="hidden" name="duration_id" value="{{ $durationInfo->duration_id }}">
        <input type="hidden" name="price" value="{{ $durationInfo->price }}">

        <div class="flex flex-col items-center">
            <label for="otp" class="block font-medium mb-1 text-center">Nhập mã OTP để ký</label>
            <input
                type="text"
                id="otp"
                name="otp"
                required
                maxlength="6"
                pattern="\d{6}"
                autocomplete="one-time-code"
                inputmode="numeric"
                class="text-center tracking-widest text-2xl font-bold border-2 border-blue-400 rounded-lg px-4 py-2 focus:border-blue-600 focus:ring focus:ring-blue-200 transition w-40"
                placeholder="______"
            >
        
        </div>

        <div class="flex flex-col items-center">
            <label for="identity_card" class="block font-medium mb-1 text-center">Căn cước công dân</label>
            <input
                type="text"
                id="identity_card"
                name="identity_card"
                required
                maxlength="12"
                pattern="\d{12}"
                inputmode="numeric"
                class="text-center tracking-widest text-lg border-2 border-blue-400 rounded-lg px-4 py-2 focus:border-blue-600 focus:ring focus:ring-blue-200 transition w-60"
                placeholder="Nhập 12 số CCCD"
                value="{{ Auth::user()->identity_card }}"
            >
            
        </div>

        <div class="flex flex-col items-center">
            <label for="contract_date" class="block font-medium mb-1 text-center">Ngày ký hợp đồng</label>
            <input
                type="text"
                id="contract_date"
                name="contract_date"
                class="text-center border-2 border-blue-400 rounded-lg px-4 py-2 w-60 bg-gray-100 cursor-not-allowed"
                value="{{ now()->format('Y-m-d H:i:s') }}"
                readonly
                tabindex="-1"
            >
           
        </div>

        <div class="flex items-center space-x-2 justify-center">
            <input type="checkbox" id="agreed_terms" name="agreed_terms" value="1" required class="h-5 w-5 text-blue-600 accent-blue-600">
            <label for="agreed_terms" class="text-gray-700 select-none">Tôi đồng ý với <a href="#terms" class="text-blue-600 underline hover:text-blue-800">các điều khoản</a></label>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Ký hợp đồng
            </button>
        </div>
    </form>


</div>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const form = document.querySelector('.contract-sign-form');
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    const saveBtn = document.getElementById('save-signature');
    const clearBtn = document.getElementById('clear-signature');
    const signatureInput = form.querySelector('#signature-data');

    // Khi vẽ, hiện nút Lưu chữ ký và gán giá trị vào input
    canvas.addEventListener('pointerup', () => {
        if (!signaturePad.isEmpty()) {
            const signatureData = signaturePad.toDataURL();
            signatureInput.value = signatureData;
            localStorage.setItem('savedSignature', signatureData);
            saveBtn.classList.remove('hidden');
        }
    });

    // Lưu chữ ký vào localStorage và input
    saveBtn.addEventListener('click', () => {
        if (!signaturePad.isEmpty()) {
            const signatureData = signaturePad.toDataURL();
            localStorage.setItem('savedSignature', signatureData);
            signatureInput.value = signatureData;
            alert('Đã lưu chữ ký!');
        } else {
            alert('Vui lòng ký trước khi lưu!');
        }
    });

    // Xóa chữ ký
    clearBtn.addEventListener('click', () => {
        signaturePad.clear();
        signatureInput.value = '';
        localStorage.removeItem('savedSignature');
        saveBtn.classList.add('hidden');
    });

    // Khi load lại trang, nếu có chữ ký thì vẽ lại
    window.addEventListener('DOMContentLoaded', () => {
        const savedSignature = localStorage.getItem('savedSignature');
        if (savedSignature) {
            signaturePad.fromDataURL(savedSignature);
            signatureInput.value = savedSignature;
            saveBtn.classList.remove('hidden');
        }
    });

    // Khi submit form, lấy chữ ký từ localStorage
    form.addEventListener('submit', function(e) {
        const signatureData = localStorage.getItem('savedSignature');
        if (!signatureData) {
            e.preventDefault();
            alert('Vui lòng ký và lưu chữ ký trước khi gửi!');
        } else {
            signatureInput.value = signatureData;
            localStorage.removeItem('savedSignature');
        }
    });
</script>

@endsection
