<!-- filepath: resources/views/contracts/pdf.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12pt; }
        .header, .footer { text-align: center; }
        .header .country { font-weight: bold; text-transform: uppercase; }
        .header .motto { font-style: italic; }
        .contract-title { font-size: 16pt; font-weight: bold; margin: 16px 0 8px 0; text-align: center; }
        .contract-number { text-align: center; margin-bottom: 16px; }
        .info-table { width: 100%; margin-bottom: 18px; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .section-title { font-weight: bold; margin: 18px 0 8px 0; }
        .terms details { margin-bottom: 8px; }
        .terms summary { font-weight: bold; }
      /* Đảm bảo chữ ký không bị cắt hoặc tràn ra ngoài khi in */
.signatures {
    margin-top: 60px;
    page-break-inside: avoid; /* Tránh việc chia cắt khi in PDF */
    width: 100%;
    display: flex; /* Chạy chữ ký theo hàng ngang */
    justify-content: space-between; /* Đảm bảo có khoảng cách đều giữa bên A và bên B */
    align-items: flex-start; /* Căn chữ ký ở đầu (top) */
}

.signature-block {
    width: 48%; /* Chữ ký chiếm 48% chiều rộng của phần container */
    text-align: center;
    padding: 10px;
    box-sizing: border-box;
}

.signature-image {
    max-width: 100%; /* Đảm bảo chữ ký không bị tràn ra ngoài */
    height: auto; /* Giữ tỷ lệ ảnh */
    margin: 10px 0;
}

.signature-title {
    font-weight: bold;
    margin-bottom: 15px;
}

.signature-name {
    margin-top: 10px;
    font-weight: bold;
}

.signature-caption {
    font-style: italic;
    font-size: 0.9em;
    margin-top: 5px;
}

/* Đảm bảo các chi tiết hợp đồng có không gian hợp lý khi in */
@media print {
    .contract-title {
        font-size: 14pt;
    }

    .section-title {
        font-weight: bold;
        margin: 15px 0;
    }

    .terms summary {
        font-weight: bold;
    }

    .footer {
        font-size: 10pt;
        margin-top: 30px;
    }

    .signatures {
        flex-direction: row; /* Chữ ký vẫn chạy ngang khi in */
        justify-content: space-between; /* Căn chỉnh các chữ ký ra hai bên */
        align-items: flex-start; /* Đảm bảo chữ ký căn trên cùng */
    }

    .signature-block {
        width: 48%; /* Cân đối lại cho vừa với chiều rộng trang in */
        margin-bottom: 0; /* Bỏ margin dưới mỗi chữ ký khi in */
    }

    .signature-image {
        max-height: 100px; /* Giới hạn chiều cao hình ảnh chữ ký khi in */
    }
}

    </style>
</head>
<body>
@php
    $signature = $signature ?? ($contract->signatures->first() ?? null);
    $endDateFormatted = date('d/m/Y', strtotime($contract->end_date));
    $customer = $contract->customer;
    $user = $customer->user;
    $companySignature = config('app.company_signature');
@endphp

<div class="header">
    <div class="country">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
    <div class="motto">Độc lập - Tự do - Hạnh phúc</div>
    <hr style="width: 180px; margin: 8px auto 16px auto; border: none; border-top: 1.5px solid #000;">
</div>

<div class="contract-title">HỢP ĐỒNG CUNG CẤP DỊCH VỤ</div>
<div class="contract-number">Số: <strong>{{ $contract->contract_number }}</strong></div>
<p style="text-align: center;">Ngày lập hợp đồng: <strong>{{ date('d/m/Y', strtotime($contract->start_date)) }}</strong></p>
{{-- thông tin 2 bên --}}
<div class="section-title">I. Thông tin các bên</div>
<p><strong>BÊN SỬ DỤNG DỊCH VỤ (sau đây gọi tắt là bên B)</strong></p>
<table class="info-table">
    <tr>
        <td>
            Họ và tên: {{ $user->name }}<br>
            Ngày sinh: {{ $user->dob ? date('d/m/Y', strtotime($user->dob)) : 'Chưa cập nhật' }}<br>
            CMND/CCCD/Hộ chiếu số: {{ $user->identity_card ?? 'Chưa cập nhật' }}<br>
            Địa chỉ: {{ $user->address ?? 'Chưa cập nhật' }}<br>
            Điện thoại liên hệ: {{ $user->phone ?? 'Chưa cập nhật' }}<br>
            Email: {{ $user->email }}<br>
            Mã số thuế: {{ $customer->tax_code ?? 'Chưa cập nhật' }}<br>
        </td>
    </tr>
</table>

<p><strong>BÊN CUNG ỨNG DỊCH VỤ (sau đây gọi tắt là bên A)</strong></p>
<table class="info-table">
    <tr>
        <td>
            Tên doanh nghiệp: {{ $companySignature['company_name'] ?? 'Công ty TNHH Công Nghệ' }}<br>
            Địa chỉ trụ sở chính: {{ $companySignature['company_address'] ?? 'Địa chỉ công ty' }}<br>
            Mã số doanh nghiệp: {{ $companySignature['company_tax_code'] ?? 'Mã số thuế' }}<br>
            Người đại diện theo pháp luật: {{ $companySignature['name'] ?? 'Người đại diện' }}; Chức vụ: {{ $companySignature['position'] ?? 'Chức vụ' }}<br>
            Điện thoại liên hệ: {{ $companySignature['company_phone'] ?? 'Số điện thoại' }}<br>
            Email: {{ $companySignature['company_email'] ?? 'Email công ty' }}<br>
        </td>
    </tr>
</table>

{{-- thông tin hđ --}}
<div class="section-title">II. Thông tin hợp đồng</div>
<table class="info-table">
    <tr>
        <td>Tên dịch vụ:</td>
        <td>{{ $contract->service->service_name }}</td>
    </tr>
    <tr>
        <td>Thời gian bắt đầu:</td>
        <td>{{ date('d/m/Y', strtotime($contract->start_date)) }}</td>
    </tr>
    <tr>
        <td>Thời gian kết thúc:</td>
        <td>{{ $endDateFormatted }}</td>
    </tr>
    <tr>
        <td>Tổng giá trị:</td>
        <td>{{ number_format($contract->total_price) }} VND</td>
    </tr>
</table>


<p>Hai bên thoả thuận và đồng ý ký kết hợp đồng dịch vụ với các điều khoản như sau:</p>

{{-- điều khoản hợp đồng --}}
<div class="section-title">III. Điều khoản hợp đồng</div>
<div class="terms">
    <details>
        <summary>Điều 1: Định Nghĩa</summary>
        <div>
            <b>Dịch vụ cung cấp:</b> Là các dịch vụ công nghệ thông tin điện tử mà bên cung cấp ("Bên A") cung cấp cho bên nhận ("Bên B").<br>
            <b>Sản phẩm công nghệ:</b> Bao gồm phần mềm, ứng dụng, hệ thống, nền tảng, giao diện hoặc tài liệu do Bên A cung cấp.
        </div>
    </details>
    <details>
        <summary>Điều 2: Phạm Vi Dịch Vụ</summary>
        <div>
            <b>Mô tả dịch vụ:</b> Cung cấp theo yêu cầu cụ thể đã thỏa thuận.<br>
            <b>Thời gian thực hiện:</b> Từ ngày ký đến khi hoàn thành.<br>
            <b>Phạm vi công việc:</b> Theo hợp đồng, yêu cầu thêm sẽ được thống nhất bổ sung.
        </div>
    </details>
    <details>
        <summary>Điều 3: Giá Cả và Thanh Toán</summary>
        <div>
            <b>Giá dịch vụ:</b> Như đã ghi trong hợp đồng.<br>
            <b>Phương thức thanh toán:</b> Chuyển khoản, tiền mặt hoặc phương thức khác.<br>
            <b>Tiến độ:</b> 50% sau ký, 30% sau 50% công việc, còn lại sau hoàn thành.
        </div>
    </details>
    <details>
        <summary>Điều 4: Hiệu Lực Của Hợp Đồng</summary>
        <div>
            <b>Hiệu lực:</b> Hợp đồng có hiệu lực kể từ ngày ký và kéo dài đến ngày {{ $endDateFormatted }}.<br>
            <b>Số bản:</b> 02 bản, mỗi bên giữ 01 bản, giá trị pháp lý như nhau.
        </div>
    </details>
    <details>
        <summary>Điều 5: Chấm Dứt Hợp Đồng</summary>
        <div>
            Hợp đồng có thể chấm dứt trước hạn khi:<br>
            - Hai bên thỏa thuận bằng văn bản.<br>
            - Một bên vi phạm nghiêm trọng.<br>
            - Sự kiện bất khả kháng theo luật.
        </div>
    </details>
    <details>
        <summary>Điều 6: Giải Quyết Tranh Chấp</summary>
        <div>
            Ưu tiên thương lượng. Nếu không thành, tranh chấp sẽ được giải quyết tại Tòa án nhân dân có thẩm quyền tại {{ config("app.company_location", "TP. Hà Nội") }}.
        </div>
    </details>
      <details>
        <summary>Điều 7: Điều khoản thi hành</summary>
        <div>
           Bên A và bên B đồng ý đã hiểu rõ quyền, nghĩa vụ, lợi ích hợp pháp của mình và hậu quả pháp lý của việc giao kết hợp đồng này.

Bên A và bên B đồng ý thực hiện theo đúng các điều khoản trong hợp đồng này và các phụ lục kèm theo. Hợp đồng này được lập thành 02 bản, mỗi bên giữ 01 bản có giá trị pháp lý như nhau.
        </div>
    </details>
</div>

<div class="signatures">
    <div class="signature-block">
        <div class="signature-title">Bên B (Khách hàng)</div>
        <div class="signature-caption">(Chữ ký, họ tên và đóng dấu nếu có)</div>
        @if(Str::startsWith($signature->signature_image, 'data:image'))
            <img src="{{ $signature->signature_image }}" alt="Chữ ký khách hàng" class="signature-image">
        @else
            <img src="data:image/png;base64,{{ $signature->signature_image }}" alt="Chữ ký khách hàng" class="signature-image">
        @endif
        <div class="signature-name">{{ $user->name }}</div>
    </div>
    <div class="signature-block">
        <div class="signature-title">Bên A (Nhà cung cấp)</div>
        <div class="signature-caption">(Chữ ký, họ tên và đóng dấu nếu có)</div>
        @if(Str::startsWith($signature->admin_signature_image, 'data:image'))
            <img src="{{ $signature->admin_signature_image }}" alt="Chữ ký công ty" class="signature-image">
        @else
            <img src="data:image/png;base64,{{ $signature->admin_signature_image }}" alt="Chữ ký công ty" class="signature-image">
        @endif
        <div class="signature-name">{{ $signature->admin_name ?? $companySignature['name'] ?? 'Người đại diện' }}</div>
     
    </div>
</div>

<div class="footer">
    <p>Hợp đồng được tạo tự động bởi hệ thống. Mọi thông tin đều có giá trị pháp lý.</p>
</div>
</body>
</html>
