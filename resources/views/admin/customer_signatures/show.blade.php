@extends('layouts.admin')
@section('title', 'Quản lý chữ ký khách hàng: ' . ($customer->user->name ?? 'N/A'))

<style>
    .signature-image {
        max-width: 150px;
        max-height: 80px;
        object-fit: contain;
    }
    
    .signature-card {
        transition: all 0.3s ease;
    }
    
    .signature-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .modal {
        transition: opacity 0.25s ease;
    }
    
    .modal-active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }
</style>

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Quản lý chữ ký của khách hàng</h1>
        <a href="{{ route('admin.customer-signatures.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thông tin khách hàng</h2>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20">
                        @if($customer->user && $customer->user->avatar)
                        <img class="h-20 w-20 rounded-full" src="{{ asset('storage/' . $customer->user->avatar) }}" alt="{{ $customer->user->name }} avatar">
                        @else
                        <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 text-xl">{{ substr($customer->user->name ?? 'U', 0, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $customer->user->name ?? 'N/A' }}</h3>
                        <p class="text-gray-500">ID: {{ $customer->id }}</p>
                        <p class="text-gray-500">Email: {{ $customer->user->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p><span class="font-medium">Số lượng hợp đồng:</span> {{ $customer->contracts->count() }}</p>
                    @php
                        $signatureCount = 0;
                        foreach($customer->contracts as $contract) {
                            $signatureCount += $contract->signatures->count();
                        }
                    @endphp
                    <p><span class="font-medium">Số lượng chữ ký:</span> {{ $signatureCount }}</p>
                    <p><span class="font-medium">Ngày tham gia:</span> {{ $customer->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Danh sách chữ ký</h2>
            <button id="uploadSignatureBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tải lên chữ ký mới
            </button>
        </div>

        @if($customer->contracts->isEmpty())
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="mt-4 text-gray-500">Khách hàng chưa có hợp đồng nào</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php $hasSignature = false; @endphp
            @foreach($customer->contracts as $contract)
                @foreach($contract->signatures as $signature)
                    @php $hasSignature = true; @endphp
                    <div class="signature-card bg-gray-50 border rounded-lg overflow-hidden">
                        <div class="p-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-2">Hợp đồng #{{ $contract->contract_number }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Dịch vụ:</span> 
                                {{ $contract->service->service_name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Ngày ký:</span> 
                                {{ $signature->signed_at ? \Carbon\Carbon::parse($signature->signed_at)->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                            <div class="border rounded-md p-2 bg-white mb-3">
                                @if($signature->signature_image)
                                    @if(str_starts_with($signature->signature_image, 'data:image'))
                                        <img src="{{ $signature->signature_image }}" alt="Chữ ký" class="signature-image mx-auto">
                                    @else
                                        <img src="{{ asset('storage/signatures/' . $signature->signature_image) }}" alt="Chữ ký" class="signature-image mx-auto">
                                    @endif
                                @else
                                    <div class="text-center text-gray-500 py-3">Không có hình ảnh</div>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <button class="text-blue-500 hover:text-blue-700 text-sm view-signature" 
                                        data-signature-id="{{ $signature->id }}"
                                        data-contract-number="{{ $contract->contract_number }}"
                                        data-signature-image="{{ $signature->signature_image }}">
                                    Xem chi tiết
                                </button>
                                <form action="{{ route('admin.customer-signatures.delete', $signature->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chữ ký này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            
            @if(!$hasSignature)
            <div class="col-span-full text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500">Khách hàng chưa có chữ ký nào</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Upload Signature Modal -->
<div id="uploadSignatureModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="modal-container bg-white w-full max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-xl font-bold">Tải lên chữ ký mới</p>
                <button id="closeUploadModal" class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('admin.customer-signatures.upload', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="contract_id" class="block text-gray-700 text-sm font-bold mb-2">Chọn hợp đồng*:</label>
                    <select name="contract_id" id="contract_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">-- Chọn hợp đồng --</option>
                        @foreach($customer->contracts as $contract)
                            <option value="{{ $contract->id }}">{{ $contract->contract_number }} - {{ $contract->service->service_name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="signature_image" class="block text-gray-700 text-sm font-bold mb-2">Chọn ảnh chữ ký*:</label>
                    <input type="file" name="signature_image" id="signature_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept="image/*" required>
                    <p class="text-gray-500 text-xs mt-1">Chỉ chấp nhận file ảnh, tối đa 2MB</p>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                        Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Signature Modal -->
<div id="viewSignatureModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="modal-container bg-white w-full max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-xl font-bold">Chi tiết chữ ký</p>
                <button id="closeViewModal" class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </button>
            </div>
            
            <div>
                <p class="text-gray-700 mb-2"><span class="font-medium">Hợp đồng:</span> <span id="modal-contract-number"></span></p>
                <div class="border rounded-md p-4 bg-gray-50 mb-3 flex justify-center">
                    <img id="modal-signature-image" src="" alt="Chữ ký" style="max-width: 100%; max-height: 200px;">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.getElementById('uploadSignatureBtn');
        const uploadModal = document.getElementById('uploadSignatureModal');
        const closeUploadBtn = document.getElementById('closeUploadModal');
        
        const viewBtns = document.querySelectorAll('.view-signature');
        const viewModal = document.getElementById('viewSignatureModal');
        const closeViewBtn = document.getElementById('closeViewModal');
        
        // Mở modal tải lên
        uploadBtn.addEventListener('click', function() {
            uploadModal.classList.remove('hidden');
        });
        
        // Đóng modal tải lên
        closeUploadBtn.addEventListener('click', function() {
            uploadModal.classList.add('hidden');
        });
        
        // Đóng modal khi click ra ngoài
        uploadModal.addEventListener('click', function(e) {
            if (e.target === uploadModal) {
                uploadModal.classList.add('hidden');
            }
        });
        
        // Mở modal xem chi tiết
        viewBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const contractNumber = this.getAttribute('data-contract-number');
                let signatureImage = this.getAttribute('data-signature-image');
                
                // Xử lý hiển thị ảnh
                if (signatureImage && !signatureImage.startsWith('data:image')) {
                    signatureImage = "{{ asset('storage/signatures') }}/" + signatureImage;
                }
                
                document.getElementById('modal-contract-number').textContent = contractNumber;
                document.getElementById('modal-signature-image').src = signatureImage;
                
                viewModal.classList.remove('hidden');
            });
        });
        
        // Đóng modal xem chi tiết
        closeViewBtn.addEventListener('click', function() {
            viewModal.classList.add('hidden');
        });
        
        // Đóng modal khi click ra ngoài
        viewModal.addEventListener('click', function(e) {
            if (e.target === viewModal) {
                viewModal.classList.add('hidden');
            }
        });
    });
</script>
@endpush 