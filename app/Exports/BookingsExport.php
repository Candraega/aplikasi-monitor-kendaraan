<?php

namespace App\Exports;
use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::with(['vehicle', 'driver', 'approvals.approver'])
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Kendaraan',
            'Plat Nomor',
            'Driver',
            'Tujuan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'Persetujuan',
        ];
    }

    public function map($booking): array
    {
        $approvers = $booking->approvals->map(function ($approval) {
            return $approval->approver->name . ' (' . $approval->status . ')';
        })->implode('; ');

        return [
            $booking->id,
            $booking->vehicle->name,
            $booking->vehicle->license_plate,
            $booking->driver->name,
            $booking->purpose,
            \Carbon\Carbon::parse($booking->start_date)->format('d-m-Y H:i'),
            \Carbon\Carbon::parse($booking->end_date)->format('d-m-Y H:i'),
            ucfirst($booking->status),
            $approvers,
        ];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $row = 2; 

            foreach ($this->collection() as $booking) {
                $status = strtolower($booking->status);

                $color = null;
                if ($status === 'approved') {
                    $color = 'FF00B050'; // Hijau
                } elseif ($status === 'rejected') {
                    $color = 'FFFF0000'; // Merah
                }

                if ($color) {
                    $event->sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                        'font' => [
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }

                $row++;
            }
        },
    ];
}

}
