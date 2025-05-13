<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hợp đồng - {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
        }
        .contract-info {
            margin-bottom: 30px;
        }
        .contract-info h2 {
            font-size: 14pt;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .info-table .label {
            font-weight: bold;
            width: 30%;
        }
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-box h3 {
            font-size: 13pt;
            margin-bottom: 10px;
        }
        .signature-image {
            height: 100px;
            margin: 20px 0;
        }
        .signature-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-date {
            font-style: italic;
            margin-bottom: 5px;
        }
        .contract-items {
            margin-bottom: 30px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            font-size: 13pt;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10pt;
            color: #666;
        }
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>HỢP ĐỒNG CUNG CẤP DỊCH VỤ</h1>
            <p>Số: <strong>{{ $contract->contract_number }}</strong></p>
        </div>
        
        <div class="contract-info">
            <h2>Thông tin hợp đồng</h2>
            <table class="info-table">
                <tr>
                    <td class="label">Tên dịch vụ:</td>
                    <td>{{ $contract->service->name }}</td>
                </tr>
                <tr>
                    <td class="label">Thời gian bắt đầu:</td>
                    <td>{{ date('d/m/Y', strtotime($contract->start_date)) }}</td>
                </tr>
                <tr>
                    <td class="label">Thời gian kết thúc:</td>
                    <td>{{ date('d/m/Y', strtotime($contract->end_date)) }}</td>
                </tr>
                <tr>
                    <td class="label">Tổng giá trị:</td>
                    <td>{{ number_format($contract->total_price) }} VND</td>
                </tr>
            </table>
        </div>
        
        <div class="section">
            <h3>Bên A (Nhà cung cấp dịch vụ)</h3>
            <p><strong>Tên công ty:</strong> Công ty Dịch vụ Công nghệ ConT</p>
            <p><strong>Địa chỉ:</strong> 123 Đường Nguyễn Văn Linh, Quận 7, TP. Hồ Chí Minh</p>
            <p><strong>Mã số thuế:</strong> 0123456789</p>
            <p><strong>Đại diện:</strong> {{ $signature->admin_name ?? 'Chưa ký' }}</p>
            <p><strong>Chức vụ:</strong> {{ $signature->admin_position ?? 'Chưa ký' }}</p>
        </div>
        
        <div class="section">
            <h3>Bên B (Khách hàng)</h3>
            <p><strong>Tên khách hàng:</strong> {{ $signature->customer_name }}</p>
            <p><strong>CMND/CCCD:</strong> {{ $signature->identity_card }}</p>
            <p><strong>Email:</strong> {{ $signature->customer_email }}</p>
        </div>
        
        <div class="section">
            <h3>Mô tả dịch vụ</h3>
            <p>{{ $contract->service->description }}</p>
        </div>
        
     <div class="signature-section">
    <div class="signature-row">
        <div class="signature-box">
            <h3>Bên A (Công ty):</h3>
            @if($adminSignaturePath)
                <img src="{{ asset('storage/' . $adminSignaturePath) }}" alt="Chữ ký công ty" class="signature-image">
            @else
                <p>Chưa có chữ ký</p>
            @endif
        </div>
        <div class="signature-box">
            <h3>Bên B (Khách hàng):</h3>
            <img src="{{ $contract->signatures->first()->signature_data }}" alt="Chữ ký khách hàng" class="signature-image">
        </div>
    </div>
</div>
        
        <div class="footer">
            <p>Hợp đồng này được tạo tự động từ hệ thống Quản lý Hợp đồng ConT</p>
            <p>Mã tham chiếu: {{ $contract->contract_number }} - Ngày tạo: {{ date('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html> 