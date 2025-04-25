@extends('layouts.customer')

@section('title', '404 - Page Not Found')

<style>
/*======================
    404 Page Styling
=======================*/
.page_404 {
    padding: 40px 20px;
    background: #f9fafb;
    font-family: 'Arvo', serif;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: calc(100vh - 80px); /* Trừ chiều cao của header */
    background-image: url('https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.error_box {
    background: rgba(255, 255, 255, 0.9); /* Nền trắng mờ */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    border: 2px solid #e5e7eb; /* Border */
    max-width: 500px;
    width: 100%;
}

.error_box h1 {
    font-size: 100px;
    color: #1f2937; /* Màu chữ */
    margin-bottom: 10px;
    font-weight: bold;
}

.error_box h3 {
    font-size: 24px;
    color: #4b5563; /* Màu chữ phụ */
    margin-bottom: 10px;
}

.error_box p {
    font-size: 16px;
    color: #6b7280; /* Màu chữ mô tả */
    margin-bottom: 20px;
}

.link_404 {
    color: #fff !important;
    padding: 10px 20px;
    background: #2563eb; /* Màu xanh */
    display: inline-block;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.link_404:hover {
    background: #1d4ed8; /* Màu xanh đậm hơn khi hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px); /* Hiệu ứng nổi lên khi hover */
}
</style>

@section('content')
<section class="page_404">
    <div class="error_box">
        <h1>404</h1>
        <h3>Oops! Page Not Found</h3>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="{{ route('customer.dashboard') }}" class="link_404">Go to Home</a>
    </div>
</section>
@endsection