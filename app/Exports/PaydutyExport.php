<?php

namespace App\Exports;

use App\Models\Apis\Payduty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class PaydutyExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Payduty::all([
            'date', 
            'location', 
            'startTime', 
            'finishTime', 
            'totalHours', 
            'officer', 
            'officerName', 
            'division', 
            'email'
        ]);
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            'Date', 
            'Location', 
            'Start Time', 
            'Finish Time', 
            'Total Hours', 
            'Officer', 
            'Officer Name', 
            'Division', 
            'Email'
        ];
    }

    public function styles($sheet)
    {
        // Style the first row (headings)
        $sheet->getStyle('1')->applyFromArray(['font' => ['bold' => true, 'size' => 14]]);

        // Auto size columns based on content
        foreach(range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Style the entire sheet font (optional)
        $sheet->getParent()->getDefaultStyle()->applyFromArray(['font' => ['name' => 'Calibri']]);
    }
}
