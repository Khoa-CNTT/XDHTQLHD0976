<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Contract;

class ReportExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithEvents
{
    public function collection()
    {
        return Contract::with(['customer.user', 'service', 'payments'])
            ->get()
            ->map(function ($contract) {
                $customer = optional($contract->customer);
                $user = optional($customer->user);
                $isPaid = $contract->payments->where('status', 'Hoàn Thành')->count() > 0 ? 'Đã thanh toán' : 'Chưa thanh toán';
                return [
                    'Số hợp đồng' => $contract->contract_number,
                    'Khách hàng' => $user->name,
                    'Email' => $user->email,
                    'Số điện thoại' => $user->phone,
                    'Mã số thuế' => $customer->tax_code,
                    'Dịch vụ' => optional($contract->service)->service_name,
                    'Tổng tiền' => number_format($contract->total_price, 0, ',', '.'),
                    'Trạng thái hợp đồng' => $contract->status,
                    'Trạng thái thanh toán' => $isPaid,
                    'Ngày tạo' => $contract->created_at ? $contract->created_at->format('d/m/Y') : '',
                    'Ngày bắt đầu' => $contract->start_date,
                    'Ngày kết thúc' => $contract->end_date,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Số hợp đồng',
            'Khách hàng',
            'Email',
            'Số điện thoại',
            'Mã số thuế',
            'Dịch vụ',
            'Tổng tiền',
            'Trạng thái hợp đồng',
            'Trạng thái thanh toán',
            'Ngày tạo',
            'Ngày bắt đầu',
            'Ngày kết thúc',
        ];
    }

    public function title(): string
    {
        return 'Báo cáo thống kê';
    }

    public function styles(Worksheet $sheet)
    {
        // In đậm dòng tiêu đề
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        // Căn giữa tiêu đề
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        // Đặt màu nền tiêu đề
        $sheet->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCE5FF');
        // Đặt viền cho tiêu đề
        $sheet->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Lấy số dòng dữ liệu
                $rowCount = $event->sheet->getDelegate()->getHighestRow();
                // Kẻ viền cho toàn bộ bảng
                $event->sheet->getStyle('A1:L' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                // Auto width cho các cột
                foreach (range('A', 'L') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}