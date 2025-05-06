@extends('layouts.customer')

@section('title', 'Trang Chủ ')

@section('content')

<div class="container mx-auto">
    {{-- Thanh hình ảnh chạy - sử dụng Alpine.js --}}
    <section 
        x-data="{
                images: [
                
                '/banners/bbb.png',
                '/banners/bbb1.png',
                '/banners/bbb2.png',
                '/banners/bbb3.png',
        
       
                ],
                currentIndex: 0,
                next() { this.currentIndex = (this.currentIndex + 1) % this.images.length },
                prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length },
                startSlider() { setInterval(() => this.next(), 5000); }
            }"
        x-init="startSlider"
        class="relative overflow-hidden rounded-xl shadow-lg h-[300px]"
        >

        <!-- Khung ảnh -->
        <div 
            class="flex h-full transition-transform duration-[1200ms] ease-[cubic-bezier(0.65,0,0.35,1)]"
            :style="{ transform: 'translateX(-' + currentIndex * 100 + '%)' }" >
            <template x-for="(image, index) in images" :key="index">
                <div class="w-full flex-shrink-0 h-full">
                    <img :src="image" class="w-full h-full object-cover" />
                </div>
            </template>
        </div>

        <!-- Button trái -->
        <button @click="prev"
            class="absolute left-3 top-1/2 transform -translate-y-1/2 
                w-9 h-9 flex items-center justify-center 
                rounded-full border border-white/50 
                bg-white/10 text-white hover:bg-white/20 
                transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Button phải -->
        <button @click="next"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 
                w-9 h-9 flex items-center justify-center 
                rounded-full border border-white/50 
                bg-white/10 text-white hover:bg-white/20 
                transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </section>

    <!-- Danh mục và Tìm kiếm -->
    <div class="bg-white shadow-sm mt-5 border border-gray-200 rounded-2xl px-1 py-2">
        <div class="container mx-auto px-4 py-3 flex gap-x-10 items-center">
            <form action="{{ route('customer.services.search') }}" method="GET" class="relative w-1/3 mr-6">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Tìm kiếm dịch vụ..." 
                    value="{{ request('query') }}" 
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
            </form>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('customer.services.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Tất Cả Dịch Vụ</a></li>
                    @foreach (\App\Models\ServiceCategory::has('services')->get() as $category)
                        <li>
                            <a href="{{ route('customer.services.filterByCategory', $category->id) }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    {{-- Danh sách hợp đồng dịch vụ --}}
    <div class="grid md:grid-cols-3 gap-6 mt-6">
        @forelse($services as $service)
        <div class="flex flex-col justify-between bg-white-800 p-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-2 glass-effect">
            
            <!-- Nhãn "Mới" (Bao phủ góc trên trái) -->
            @if($service->created_at && $service->created_at->gt(now()->subDays(3)) && !$service->is_hot)
            <span class="absolute top-0 left-0 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-br-full">
                Mới
            </span>
            @endif

            <!-- Nhãn "Hot" (Bao phủ góc trên phải) -->
            @if($service->is_hot)
                <span class="absolute top-0 right-0 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-bl-full">
                    Hot
                </span>
            @endif

        
            <!-- Nội dung dịch vụ -->
            <div>
                <div class="w-100 h-64 overflow-hidden rounded-lg">
                    <img class="w-full h-full object-cover" src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/default.jpg') }}" 
                    alt="{{ $service->service_name }}" >
                </div>  
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->service_name }}</h3>
                <p class="text-gray-600 mb-2 line-clamp-3">{{ $service->description }}</p>
                <p class="text-gray-600 mb-1"><strong>Loại dịch vụ:</strong> {{ $service->category->name ?? 'Không có danh mục' }}</p>
                <p class="text-gray-600 mb-4"><strong>Giá:</strong> 
                    <span class="text-green-600 font-bold">{{ number_format($service->price, 0, ',', '.') }} VND</span>
                </p>
            </div>
            <div>
                <a href="{{ route('customer.services.show', $service->id) }}" 
                   class="text-sm px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition inline-block">
                    Xem Hợp Đồng
                </a>
            </div>
        </div>
        @empty
        <p class="text-gray-600">Chúng tôi rất tiếc ,không có dịch vụ nào bạn đang tìm kiếm cả!!!</p>
        @endforelse
    </div>
    
    
    <!-- Hiển thị phân trang -->
    <div class="mt-6">
        <div class="flex justify-center space-x-4">
            @if ($services->onFirstPage())
                <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-l-lg">Trang đầu</span>
            @else
                <a href="{{ $services->previousPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded-l-lg hover:bg-blue-700">Trang đầu</a>
            @endif

            <span class="px-4 py-2 text-gray-500">Trang {{ $services->currentPage() }} / {{ $services->lastPage() }}</span>

            @if ($services->hasMorePages())
                <a href="{{ $services->nextPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">Trang sau</a>
            @else
                <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-r-lg">Trang sau</span>
            @endif
        </div>
    </div>

   <!-- Hero -->
   <section class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20">
    <div class="container mx-auto px-6 text-center" data-aos="fade-down">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Chào mừng đến với dịch vụ của chúng tôi</h1>
        <p class="text-lg mb-8">Giải pháp số toàn diện, giúp doanh nghiệp phát triển bền vững.</p>
        <a href="#" class="bg-white text-blue-600 px-6 py-3 rounded shadow hover:bg-gray-100 transition">Khám phá ngay</a>
    </div>
</section>

<!-- Giới thiệu -->
<section class="bg-white py-20">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-6">
        <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOY6FMqknMhKDaKPvZB0LJVNtpu954LaK3WA&s" alt="Ảnh giới thiệu" class="w-full rounded-lg shadow-md">
        </div>
        <div class="md:w-1/2 md:pl-12" data-aos="fade-left">
            <h2 class="text-3xl font-bold mb-4">Giới Thiệu Về Chúng Tôi</h2>
            <p class="text-gray-700 text-lg">Chúng tôi cung cấp các giải pháp công nghệ tiên tiến, giúp doanh nghiệp thích nghi và phát triển mạnh mẽ trong kỷ nguyên số.</p>
        </div>
    </div>
</section>

<!-- Dịch vụ -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-12" data-aos="zoom-in">Dịch Vụ Nổi Bật</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div data-aos="flip-left" class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Thiết kế website</h3>
                <p class="text-gray-600">Trang web hiện đại, chuẩn SEO, dễ sử dụng và tương thích đa thiết bị.</p>
            </div>
            <div data-aos="flip-up" class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Ứng dụng di động</h3>
                <p class="text-gray-600">Xây dựng ứng dụng Android & iOS hiệu quả, linh hoạt theo yêu cầu.</p>
            </div>
            <div data-aos="flip-right" class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2">Tư vấn chuyển đổi số</h3>
                <p class="text-gray-600">Tư vấn chiến lược và triển khai công nghệ cho doanh nghiệp hiện đại.</p>
            </div>
        </div>
    </div>
</section>

<!-- Liên hệ -->
<section class="bg-indigo-600 text-white py-20 text-center">
    <div class="container mx-auto px-6" data-aos="zoom-in-up">
        <h2 class="text-3xl font-bold mb-4">Liên Hệ Với Chúng Tôi</h2>
        <p class="mb-6 text-lg">Chúng tôi luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p>
        <a href="#" class="bg-white text-indigo-600 px-8 py-4 rounded-lg text-lg shadow hover:bg-gray-200 transition">Liên hệ ngay</a>
    </div>
</section>

<!-- AOS script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
    


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
@endsection