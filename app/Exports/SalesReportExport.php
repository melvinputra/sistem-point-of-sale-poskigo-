<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $customerId;
    protected $itemId;
    protected $categoryId;

    public function __construct($startDate, $endDate, $customerId = null, $itemId = null, $categoryId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->customerId = $customerId;
        $this->itemId = $itemId;
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        $query = Sale::with(['user', 'customer', 'saleItems.item'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->customerId) {
            $query->where('customer_id', $this->customerId);
        }

        if ($this->itemId) {
            $query->whereHas('saleItems', function($q) {
                $q->where('item_id', $this->itemId);
            });
        }

        if ($this->categoryId) {
            $query->whereHas('saleItems.item', function($q) {
                $q->where('category_id', $this->categoryId);
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Waktu',
            'Kasir',
            'Pelanggan',
            'Subtotal',
            'Pajak',
            'Diskon',
            'Total',
            'Cash Dibayar',
            'Kembalian',
            'Kode Promo',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->created_at->format('d/m/Y'),
            $sale->created_at->format('H:i:s'),
            $sale->user->name,
            $sale->customer ? $sale->customer->name : 'Umum',
            $sale->subtotal ?? ($sale->total_amount - ($sale->tax_amount ?? 0) + ($sale->discount_amount ?? 0)),
            $sale->tax_amount ?? 0,
            $sale->discount_amount ?? 0,
            $sale->total_amount,
            $sale->cash_paid ?? 0,
            $sale->change_amount ?? 0,
            $sale->promotion ? $sale->promotion->code : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e88e5']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}
