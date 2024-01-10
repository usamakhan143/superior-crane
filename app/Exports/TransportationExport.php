<?php

namespace App\Exports;

use App\Models\Apis\Transportation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransportationExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public function collection()
    {
        return Transportation::all([
            'ticketNumber', 
            'pickupAddress', 
            'billingAddress', 
            'TimeIn', 
            'TimeOut', 
            'notes', 
            'specialInstructionsForJobNumber', 
            'poNumber', 
            'specialInstructionsForPoNumber', 
            'siteContactName', 
            'specialInstructionsForSiteContactName', 
            'siteContactNumber', 
            'specialInstructionsForSiteContactNumber', 
            'shipperName', 
            'shipperDate', 
            'shipperTimeIn',
            'shipperTimeOut', 
            'pickupDriverName', 
            'pickupDriverDate', 
            'pickupDriverTimeIn', 
            'pickupDriverTimeOut', 
            'customerName', 
            'customerDate', 
            'customerTimeIn', 
            'customerTimeOut', 
            'customerEmail', 
            'isDraft'
        ]);
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            'Ticket No.', 
            'Pickup Address', 
            'Billing Address', 
            'Time-In', 
            'Time-Out', 
            'Notes',
            'Special Instructions with Job Number', 
            'PO Number', 
            'Special Instructions with PO.Number', 
            'Site Contact Name', 
            'Special Instructions with Site Contact Name',
            'Site Contact Number', 
            'Special Instructions with Site Contact Number', 
            'Shipper Name', 
            'Shipper Date', 
            'Shipper Time-In',
            'Shipper Time-Out',
            'Pickup Driver Name', 
            'Pickup Driver Date',
            'Pickup Driver Time-In',
            'Pickup Driver Time-Out',
            'Customer Name', 
            'Customer Date',
            'Customer Time-In',
            'Customer Time-Out',
            'Customer Email',
            'Draft'
        ];
    }


    public function map($row): array
    {
        // Map the 'Draft' column value to 'Yes' or 'No'
        return [
            $row->ticketNumber,
            $row->pickupAddress,
            $row->billingAddress,
            $row->TimeIn,
            $row->TimeOut,
            $row->notes,
            $row->specialInstructionsForJobNumber,
            $row->poNumber,
            $row->specialInstructionsForPoNumber,
            $row->siteContactName,
            $row->specialInstructionsForSiteContactName,
            $row->siteContactNumber,
            $row->specialInstructionsForSiteContactNumber,
            $row->shipperName,
            $row->shipperDate,
            $row->shipperTimeIn,
            $row->shipperTimeOut,
            $row->pickupDriverName,
            $row->pickupDriverDate,
            $row->pickupDriverTimeIn,
            $row->pickupDriverTimeOut,
            $row->customerName,
            $row->customerDate,
            $row->customerTimeIn,
            $row->customerTimeOut,
            $row->customerEmail,
            $row->isDraft == 1 ? 'Yes' : 'No',
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
