<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\PdfRequest;
use App\Models\Apis\Rigger;
use PDF;

class PdfController extends Controller
{
    public function generatePdf($id)
    {

        $data = Rigger::where('id', $id)->first();

        $pdfOptions = [
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];

        $pdf = PDF::loadView('pdf.riggerpayduty', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);
        $pdfPath = storage_path('app/pdf/riggertickets') . '/' . $data->ticketNumber . '.pdf';
        $pdf->save($pdfPath);

        return $pdf->download($data->ticketNumber . '.pdf');
    }
}
