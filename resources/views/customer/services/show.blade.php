@extends('layouts.customer')

@section('title', 'Chi Tiết Dịch Vụ')

@section('content')
<div class="container mx-auto mt-6">
    {{-- Thông tin tổng quát dịch vụ --}}
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-bold text-blue-700">{{ $service->service_name }}</h2>
            <span class="text-pink-600 text-2xl font-semibold">
                {{ number_format($service->price, 0, ',', '.') }} VND
            </span>
        </div>
        <p class="text-gray-700 text-md mb-2"><strong>Loại dịch vụ:</strong> {{ $service->service_type }}</p>
        <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($service->content), 200, '...') }}</p>

        <div class="flex space-x-4 mt-4">
            <a href="{{ route('customer.services.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Quay Lại
            </a>
            <a href="#" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Yêu Cầu Hợp Đồng
            </a>
        </div>
    </div>

    {{-- Thông tin chi tiết --}}
    <div class="mt-8 bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Thông tin chi tiết</h3>
        <div class="prose max-w-full text-gray-700">
            {!! $service->content !!}
        </div>
        <h4>1. Ưu đãi gói cước</h4>
<ul>
    <li>Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực</li>
    <li>Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6</li>
    <li><strong>Wifi Mesh 5:</strong>
        <ul class="ml-4 list-disc">
            <li>Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở.</li>
            <li>Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz</li>
            <li>Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất</li>
            <li>Hỗ trợ đồng thời 40 thiết bị</li>
            <li>Cài đặt dễ dàng, triển khai linh hoạt.</li>
        </ul>
    </li>
    <li><strong>Wifi Mesh 6:</strong>
        <ul class="ml-4 list-disc">
            <li>Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao.</li>
            <li>Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz</li>
            <li>Kết nối liền mạch, phù hợp mọi ngóc ngách</li>
            <li>Hỗ trợ đồng thời 100 thiết bị</li>
            <li>Độ trễ giảm 50%</li>
        </ul>
    </li>
    <li>Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7</li>
</ul>

<h4 class="mt-4">2. Cước đấu nối hòa mạng</h4>
<p>Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: <strong>300.000 VNĐ/thuê bao</strong> (đã bao gồm VAT)</p>

<h4 class="mt-4">3. Khu vực áp dụng</h4>
<p>Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố</p>

<h4 class="mt-4">4. Tổng đài hỗ trợ</h4>
<p>Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ <strong>1800 1166</strong> (miễn phí)</p>

    </div>
</div>
@endsection
