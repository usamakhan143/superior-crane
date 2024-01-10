<?php

namespace App\Exports;

use App\Models\Apis\Rigger;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class RiggerExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Rigger::all([
            'ticketNumber', 
            'specificationsAndRemarks', 
            'customer', 
            'location', 
            'poNumber', 
            'date', 
            'startJob', 
            'arrivalYard', 
            'travelTime', 
            'totalHours', 
            'rating', 
            'operation', 
            'emailAddress', 
            'notesOthers', 
            'leaveYard', 
            'finishJob', 
            'lunch', 
            'craneTime', 
            'craneNumber', 
            'boomLength', 
            'otherEquipment'
        ]);
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            'Ticket Number', 
            'Specifications & Remarks', 
            'Customer', 
            'Location', 
            'PO Number', 
            'Date', 
            'Start Job', 
            'Arrival Yard', 
            'Travel Time', 
            'Total Hours', 
            'Rating', 
            'Operation', 
            'Email', 
            'Notes', 
            'Leave Yard', 
            'Finish Job', 
            'Lunch', 
            'Crane Time', 
            'Crane Number', 
            'Boom Length', 
            'Equipment to be used'
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
