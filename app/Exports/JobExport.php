<?php

namespace App\Exports;

use App\Models\Apis\Job;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public function collection()
    {
        return Job::all([
            'job_number',
            'client_name',
            'job_date',
            'job_time',
            'address',
            'equipment_used',
            'rigger_assigned',
            'supplier_name',
            'notes',
            'enter_by',
            'status_code',
            'is_scci',
            'pdf_rigger',
            'pdf_transportation'
        ]);
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            'Job Number',
            'Client Name',
            'Job Date',
            'Job Time',
            'Address',
            'Equipment Used',
            'Rigger Assigned',
            'Supplier Name',
            'Notes',
            'Enter by',
            'Status',
            'SCCI',
            'Rigger PDF',
            'Transportation PDF'
        ];
    }


    public function map($row): array
    {
        // Map the 'Draft' column value to 'Yes' or 'No'
        return [
            $row->job_number,
            $row->client_name,
            $row->job_date,
            $row->job_time,
            $row->address,
            $row->equipment_used,
            $row->rigger_assigned,
            $row->supplier_name,
            $row->notes,
            $row->enter_by,
            $row->status_code,
            $row->is_scci ? 'Yes' : 'No',
            $row->pdf_rigger,
            $row->pdf_transportation
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
