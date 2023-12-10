<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
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
        $pdfData = [
            'folder_name' => 'riggertickets',
            'file_name' => $data->ticketNumber,
            'file_type' => 'riggerpayduty-pdf',
            'file_ext' => 'pdf'
        ];
        $pdfPath = Fileupload::pdfUpload($pdf, $pdfData['folder_name'], $pdfData['file_name']);

        $saveInDb = Helper::addFile($pdfPath, $pdfData['file_type'], $pdfData['file_ext'], 0, $data->account_id, $data->id, 0, 0);
        $getFullPath = $saveInDb['data']->base_url . $saveInDb['data']->file_url;
        return response()->json([
            'status' => 200,
            'message' => 'PDF generated successfully.',
            'pdf' => $getFullPath
        ]);
    }
}
