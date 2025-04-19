@extends('layouts.customer')

@section('title', 'Hợp Đồng Của Tôi')

@section('content')
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-8 text-center mt-2 text-black">
                Hợp Đồng Của Tôi
            </h1>

            <!-- Bộ lọc & Tìm kiếm -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Bộ Lọc & Tìm Kiếm</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Lọc theo trạng thái hợp đồng</label>
                        <select id="status-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option>Đang chờ ký</option>
                            <option>Đã ký</option>
                            <option>Đang thực hiện</option>
                            <option>Hoàn thành</option>
                            <option>Đã hủy</option>
                        </select>
                    </div>
                    <div>
                        <label for="service-filter" class="block text-sm font-medium text-gray-700">Lọc theo dịch vụ đã đăng ký</label>
                        <input type="text" id="service-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Mã hợp đồng, tên dịch vụ...">
                    </div>
                </div>
            </div>

            <!-- Danh Sách Hợp Đồng -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Danh Sách Hợp Đồng</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white text-left px-3 py-1 text-sm ">
                        <th class="p-3 w-32">Mã Hợp Đồng</th>
                        <th class="p-3 w-48">Tên Dịch Vụ</th>
                        <th class="p-3 w-40">Ngày Tạo</th>
                        <th class="p-3 w-40">Ngày Kết Thúc</th>
                        <th class="p-3 w-40">Trạng Thái</th>
                        <th class="p-3 w-60 text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                        <td class="p-3">HD001</td>
                        <td class="p-3">Dịch Vụ 1</td>
                        <td class="p-3">2025-01-01</td>
                        <td class="p-3">2025-05-05</td>
                        <td class="p-3">
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm inline-block">
                            Đang thực hiện
                            </span>
                        </td>
                        <td class="p-3 flex space-x-2">
                            <button onclick="openModal('HD001')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                            📄 <span class="ml-1">Xem</span>
                            </button>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                            ❌ <span class="ml-1">Hủy</span>
                            </button>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for contract details -->
    <div id="contract-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-4xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Chi Tiết Hợp Đồng</h2>
                <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div id="contract-details-content">
                <!-- Contract details will be loaded here -->
            </div>
        </div>
    </div>


    <script>
        function openModal(contractId) {
            // Load contract details based on contractId
            const contractDetails = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mã Hợp Đồng</label>
                        <p class="mt-1 text-gray-900">${contractId}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tên Dịch Vụ</label>
                        <p class="mt-1 text-gray-900">Dịch Vụ 1</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Giá Dịch Vụ</label>
                        <p class="mt-1 text-gray-900">$1000</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày Tạo Hợp Đồng</label>
                        <p class="mt-1 text-gray-900">2025-01-01</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày Bắt Đầu</label>
                        <p class="mt-1 text-gray-900">2025-01-01</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày Kết Thúc</label>
                        <p class="mt-1 text-gray-900">2025-12-31</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Trạng Thái Hợp Đồng</label>
                        <p class="mt-1 text-green-700">Đang thực hiện</p>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-semibold mb-2">Điều Khoản Hợp Đồng</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                </div>
                <div class="flex space-x-4">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Tải hợp đồng (PDF)</button>
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">Ký hợp đồng điện tử</button>
                    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Hủy hợp đồng</button>
                </div>
            `;
            document.getElementById('contract-details-content').innerHTML = contractDetails;
            document.getElementById('contract-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('contract-modal').classList.add('hidden');
        }
    </script>
@endsection