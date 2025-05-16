
@extends('layouts.admin')
@section('title', 'Tải lên chữ ký tay')

@push('scripts')
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        customClass: {
            popup: 'rounded-md shadow-md px-4 py-2 text-sm'
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        customClass: {
            popup: 'rounded-md shadow-md px-4 py-2 text-sm'
        }
    });
</script>
@endif
@endpush

<style>
    body {
        background: #f3f6fa;
    }
    .signature-preview img {
        max-height: 120px;
        width: auto;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 8px;
    }
    #signature-pad {
        border: 2px dashed #2563eb;
        border-radius: 8px;
        background-color: #f8fafc;
        width: 100%;
        height: 180px;
        display: block;
        cursor: crosshair;
    }
</style>

@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-10">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 3.487a2.25 2.25 0 0 1 3.182 3.182l-9.193 9.193a2.25 2.25 0 0 1-1.06.59l-4.13 1.032a.75.75 0 0 1-.91-.91l1.032-4.13a2.25 2.25 0 0 1 .59-1.06l9.193-9.193z"></path></svg>
            Quản lý chữ ký công ty
        </h2>


        <form id="signature-form" action="{{ route('admin.signature.save') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="signature" class="block text-sm font-medium text-gray-700 mb-1">Chọn file chữ ký (ảnh PNG/JPG):</label>
                <input type="file" name="signature" id="signature" accept="image/png,image/jpeg" class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hoặc vẽ chữ ký trực tiếp:</label>
                <div class="rounded-lg bg-gray-50 border border-blue-200 p-3">
                    <canvas id="signature-pad"></canvas>
                </div>
                <input type="hidden" name="signature_pad_data" id="signature-pad-data">
                <div class="flex gap-2 mt-2">
                    <button type="button" id="clear-signature" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Xóa chữ ký</button>
                </div>
            </div>

            @if($signaturePath)
            <div class="signature-preview mt-4">
                <p class="text-sm text-gray-600 mb-1">Chữ ký hiện tại:</p>
                <img src="{{ $signaturePath }}" alt="Chữ ký hiện tại">
            </div>
            @else
            <p class="text-gray-500 mt-4">Chưa có chữ ký nào được lưu.</p>
            @endif

            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                <a href="{{ route('admin.contracts.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-center hover:bg-gray-300 transition">← Quay lại</a>
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Lưu chữ ký tay</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    const signaturePadData = document.getElementById('signature-pad-data');
    const clearButton = document.getElementById('clear-signature');
    const form = document.getElementById('signature-form');

    // Đặt kích thước cho canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const width = canvas.offsetWidth;
        const height = 180;
        canvas.width = width * ratio;
        canvas.height = height * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        canvas.style.height = height + 'px';
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    clearButton.addEventListener('click', () => {
        signaturePad.clear();
        signaturePadData.value = '';
    });

    form.addEventListener('submit', function (e) {
        const hasDraw = !signaturePad.isEmpty();
        const hasFile = document.getElementById('signature').files.length > 0;
        if (!hasDraw && !hasFile) {
            e.preventDefault();
            alert('Bạn phải chọn hoặc vẽ chữ ký.');
            return false;
        }
        if (hasDraw) {
            signaturePadData.value = signaturePad.toDataURL('image/png');
        }
    });
</script>
@endpush