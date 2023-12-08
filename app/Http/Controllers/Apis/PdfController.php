<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\PdfRequest;
use App\Models\Apis\Rigger;
use PDF;

class PdfController extends Controller
{
    public function generatePdf($id) {

        $data = Rigger::where('id', $id)->first();

        $pdf = PDF::loadView('pdf.riggerpayduty', ['data' => $data])->setPaper('A4', 'landscape')->set_option('isHtml5ParserEnabled', true);

        return $pdf->download('sample.pdf');

    }
}
