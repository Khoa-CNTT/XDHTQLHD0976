@extends('layouts.customer')

@section('title', 'Ký Hợp Đồng Dịch Vụ')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-10 rounded-xl shadow-lg mt-10 space-y-10 border border-gray-200">
    <!-- Tiêu đề -->
    <div class="border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Chi Tiết Hợp Đồng Dịch Vụ</h2>
    </div>

    <!-- Thông tin -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Thông tin khách hàng -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Thông Tin Khách Hàng</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><span class="font-medium">Tên:</span> Nguyễn Văn A</p>
                <p><span class="font-medium">Email:</span> nguyenvana@example.com</p>
            </div>
        </div>

        <!-- Thông tin dịch vụ -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Thông Tin Dịch Vụ</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><span class="font-medium">Tên Dịch Vụ:</span> Thiết kế website chuẩn SEO</p>
                <p><span class="font-medium">Giá:</span> 30.000.000 VNĐ</p>
                <p><span class="font-medium">Thời Gian:</span> 01/06/2025 → 30/11/2025</p>
            </div>
        </div>
    </div>

    <!-- Điều khoản -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 max-h-64 overflow-y-auto">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Điều Khoản Hợp Đồng</h3>
        <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600 leading-relaxed">
            <p>1. Bên A (Khách hàng) cam kết cung cấp đầy đủ thông tin cần thiết cho Bên B để triển khai dịch vụ.</p>
            <p>2. Bên B (Nhà cung cấp) có trách nhiệm hoàn thành dịch vụ đúng thời hạn như đã thỏa thuận.</p>
            <p>3. Hai bên sẽ phối hợp xử lý nếu có phát sinh hoặc sự cố trong quá trình thực hiện hợp đồng.</p>
            <p>4. Chi phí dịch vụ là 30.000.000 VNĐ và sẽ được thanh toán thành 2 đợt: 50% khi ký hợp đồng, 50% sau khi hoàn tất.</p>
            <p>5. Hợp đồng có hiệu lực từ ngày 01/06/2025 đến 30/11/2025.</p>
            <p>6. Hai bên cam kết không tiết lộ thông tin hợp đồng cho bên thứ ba nếu không có sự đồng ý của bên còn lại.</p>
            <p>7. Trường hợp tranh chấp phát sinh, hai bên sẽ thương lượng. Nếu không thành, vụ việc sẽ được đưa ra Tòa án nhân dân TP. HCM giải quyết.</p>
            <p>...</p>
        </ul>
    </div>

    <!-- Form ký -->
    <form id="signForm" method="POST" action="#">
        @csrf

        <!-- Đồng ý -->
        <div class="flex items-start space-x-3">
            <input type="checkbox" id="agree" required class="mt-1 accent-blue-600 w-4 h-4">
            <label for="agree" class="text-sm text-gray-700">
                Tôi xác nhận đã đọc và đồng ý với các điều khoản nêu trên.
            </label>
        </div>

        <!-- Ký tên -->
        <div class="mt-6">
            <label class="block text-gray-700 font-medium mb-2">Chữ Ký:</label>
            <canvas id="signature-pad" class="border border-gray-300 rounded-md w-full h-40 bg-gray-50 shadow-inner"></canvas>
            <button type="button" id="clear" class="mt-2 inline-block px-4 py-1.5 text-sm bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Xoá Chữ Ký
            </button>
            <input type="hidden" name="signature_data" id="signature-data">
        </div>

        <!-- Nút hành động -->
        <div class="mt-8 flex flex-col md:flex-row justify-between gap-4">
            <a href="{{ route('customer.dashboard') }}"
               class="w-full md:w-auto text-center bg-gray-100 text-gray-800 border border-gray-300 py-2 px-6 rounded hover:bg-gray-200 transition">
                Quay Lại
            </a>
            <button type="submit"
               class="w-full md:w-auto bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700 transition">
               Ký Hợp Đồng
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    const clearButton = document.getElementById('clear');
    const signatureInput = document.getElementById('signature-data');

    clearButton.addEventListener('click', function () {
        signaturePad.clear();
    });

    document.getElementById('signForm').addEventListener('submit', function (e) {
        if (!document.getElementById('agree').checked) {
            alert('Vui lòng xác nhận bạn đã đọc điều khoản.');
            e.preventDefault();
            return;
        }

        if (signaturePad.isEmpty()) {
            alert('Bạn chưa ký tên!');
            e.preventDefault();
        } else {
            signatureInput.value = signaturePad.toDataURL();
        }
    });
</script>
@endsection
