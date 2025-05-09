<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Thanh Toán</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #3182ce;
            margin-bottom: 5px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2b6cb0;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            width: 180px;
            font-weight: bold;
        }
        .info-value {
            flex: 1;
        }
        .summary {
            margin-top: 30px;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
        }
        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #2b6cb0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 70px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SignFlow</div>
            <div>Dịch Vụ Công Nghệ Thông Tin</div>
            <div>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</div>
            <div>Điện thoại: 0987 654 321 | Email: info@signflow.com</div>
        </div>

        <div class="title">HÓA ĐƠN THANH TOÁN</div>
        
        <div class="info-section">
            <div class="section-title">Thông Tin Khách Hàng</div>
            <div class="info-row">
                <div class="info-label">Tên khách hàng:</div>
                <div class="info-value">{{ $payment->contract->customer->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $payment->contract->customer->user->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Điện thoại:</div>
                <div class="info-value">{{ $payment->contract->customer->user->phone ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Địa chỉ:</div>
                <div class="info-value">{{ $payment->contract->customer->user->address ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Thông Tin Thanh Toán</div>
            <div class="info-row">
                <div class="info-label">Mã hóa đơn:</div>
                <div class="info-value">INV-{{ $payment->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Ngày thanh toán:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phương thức thanh toán:</div>
                <div class="info-value">{{ $payment->method }} @if($payment->payment_type)({{ $payment->payment_type }})@endif</div>
            </div>
            <div class="info-row">
                <div class="info-label">Mã giao dịch:</div>
                <div class="info-value">{{ $payment->transaction_id ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Chi Tiết Dịch Vụ</div>
            <table>
                <thead>
                    <tr>
                        <th>Dịch Vụ</th>
                        <th>Mã Hợp Đồng</th>
                        <th>Thời Hạn</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $payment->contract->service->service_name }}</td>
                        <td>{{ $payment->contract->contract_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->contract->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payment->contract->end_date)->format('d/m/Y') }}</td>
                        <td>{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="summary">
            <div class="info-row">
                <div class="info-label">Tổng tiền:</div>
                <div class="info-value amount">{{ number_format($payment->amount, 0, ',', '.') }} VND</div>
            </div>
            <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">{{ $payment->status }}</div>
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Khách hàng</div>
                <div>{{ $payment->contract->customer->user->name }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-title">Đại diện công ty</div>
                <div>SignFlow</div>
            </div>
        </div>

        <div class="footer">
            <p>Hóa đơn này được tạo tự động bởi hệ thống và có giá trị pháp lý khi có đầy đủ chữ ký, con dấu.</p>
            <p>Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi!</p>
            <p>Ngày in: {{ date('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html> 