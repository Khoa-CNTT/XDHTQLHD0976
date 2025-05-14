@extends('layouts.admin')
@section('title', 'Tải lên chữ ký tay')

<style>
    #signature-pad {
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        width: 100%;
        height: 200px; /* Đặt chiều cao cố định */
        display: block;
    }

    .signature-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .signature-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .signature-preview img {
        max-height: 100px;
        width: auto;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .upload-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Popup styles */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    .popup button {
        background: #3490dc;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

@section('content')

<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-6">Tải lên chữ ký tay</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="signature-form" action="{{ route('admin.signature.save') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="mb-4">
            <label for="signature" class="block text-sm font-medium text-gray-700">Chọn file chữ ký:</label>
            <input type="file" name="signature" id="signature" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="upload-container">
            <label class="block text-sm font-medium text-gray-700">Hoặc vẽ chữ ký:</label>
            <div class="border rounded-md bg-gray-100 p-4">
                <canvas id="signature-pad"></canvas>
            </div>
            <input type="hidden" name="signature_pad_data" id="signature-pad-data">
            <div class="signature-actions mt-2">
                <button type="button" id="clear-signature" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa chữ ký</button>
            </div>
        </div>

        @if($signaturePath)
        <div class="mb-4 signature-preview">
            <p>Chữ ký hiện tại:</p>
            <img src="{{ $signaturePath }}" alt="Chữ ký hiện tại">
        </div>
        @else
        <p class="text-gray-500">Chưa có chữ ký nào được lưu.</p>
        @endif

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu chữ ký tay</button>
    </form>
</div>

<!-- Popup Notification -->
<div class="popup" id="popup">
    <div class="popup-content">
        <p id="popup-message"></p>
        <button id="popup-close">Đóng</button>
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
    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popup-message');
    const popupClose = document.getElementById('popup-close');

    // Đặt kích thước cho canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const width = canvas.offsetWidth;
        const height = canvas.offsetHeight;

        if (canvas.width !== width * ratio || canvas.height !== height * ratio) {
            canvas.width = width * ratio;
            canvas.height = height * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
        }
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    clearButton.addEventListener('click', () => {
        signaturePad.clear();
        signaturePadData.value = ''; // Xóa dữ liệu khi nhấn "Xóa chữ ký"
    });

    form.addEventListener('submit', function (e) {
        const hasDraw = !signaturePad.isEmpty();
        const hasFile = document.getElementById('signature').files.length > 0;
        if (!hasDraw && !hasFile) {
            e.preventDefault();
            showPopup('Bạn phải chọn hoặc vẽ chữ ký.');
            return false;
        }
        if (hasDraw) {
            signaturePadData.value = signaturePad.toDataURL('image/png');
        }
    });

    // Lắng nghe sự kiện chọn file chữ ký
    document.getElementById('signature').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('signature', file);

            // Gửi dữ liệu lên server
            fetch("{{ route('admin.signature.save') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showPopup('Ảnh chữ ký đã được lưu thành công.');
                } else {
                    showPopup('Có lỗi xảy ra khi lưu ảnh chữ ký.');
                }
            })
            .catch(error => {
                showPopup('Có lỗi xảy ra khi gửi yêu cầu.');
            });
        }
    });

    function showPopup(message) {
        popupMessage.textContent = message;
        popup.style.display = 'flex';
    }

    popupClose.addEventListener('click', function() {
        popup.style.display = 'none';
    });
</script>
@endpush
