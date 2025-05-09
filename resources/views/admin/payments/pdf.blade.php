<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Thanh Toán</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
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
            text-align: center;
        }
        .subtitle {
            font-size: 16px;
            margin-bottom: 10px;
            color: #4a5568;
            text-align: center;
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
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .summary-row {
            display: flex;
            margin-bottom: 5px;
        }
        .summary-label {
            width: 200px;
            font-weight: bold;
        }
        .summary-value {
            flex: 1;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .status-success {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-failed {
            color: red;
            font-weight: bold;
        }
        .amount {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SignFlow</div>
        <div>Dịch Vụ Công Nghệ Thông Tin</div>
    </div>

    <div class="title">BÁO CÁO THANH TOÁN</div>
    
    <div class="subtitle">
        @if($startDate && $endDate)
            Từ ngày: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @elseif($startDate)
            Từ ngày: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
        @elseif($endDate)
            Đến ngày: {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @else
            Tất cả thời gian
        @endif
    </div>

    <div class="summary">
        <div class="summary-title">Tổng quan:</div>
        <div class="summary-row">
            <div class="summary-label">Tổng số giao dịch:</div>
            <div class="summary-value">{{ $payments->count() }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Giao dịch thành công:</div>
            <div class="summary-value">{{ $payments->where('status', 'Hoàn Thành')->count() }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Giao dịch đang xử lý:</div>
            <div class="summary-value">{{ $payments->whereIn('status', ['Đang Xử Lý', 'Đang Đợi'])->count() }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Giao dịch thất bại:</div>
            <div class="summary-value">{{ $payments->where('status', 'Thất Bại')->count() }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Tổng doanh thu:</div>
            <div class="summary-value"><strong>{{ number_format($totalAmount, 0, ',', '.') }} VND</strong></div>
        </div>
    </div>

    <div class="title" style="margin-top: 30px; font-size: 16px;">DANH SÁCH GIAO DỊCH</div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã hợp đồng</th>
                <th>Khách hàng</th>
                <th>Số tiền</th>
                <th>Thời gian</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->contract ? $payment->contract->contract_number : 'N/A' }}</td>
                <td>
                    @if ($payment->contract && $payment->contract->customer)
                    {{ $payment->contract->customer->user->name }}
                    @else
                    N/A
                    @endif
                </td>
                <td class="amount">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                <td>{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i') }}</td>
                <td>{{ $payment->method }}</td>
                <td>
                    <span class="{{ $payment->status === 'Hoàn Thành' ? 'status-success' : 
                    ($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi' ? 'status-pending' : 
                    'status-failed') }}">
                        {{ $payment->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Không có dữ liệu thanh toán</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Báo cáo này được tạo tự động bởi hệ thống.</p>
        <p>Ngày tạo: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 