<?php

namespace App\Http\Controllers\Apis;

use App\Exports\PaydutyExport;
use App\Exports\RiggerExport;
use App\Exports\TransportationExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportexcelController extends Controller
{
    // Rigger data Export to excel
    public function exportToExcelFromRigger(){
        return Excel::download(new RiggerExport, 'rigger.xlsx');
    }

    // Transportation data Export to excel
    public function exportToExcelFromTransportation(){
        return Excel::download(new TransportationExport, 'transportation.xlsx');
    }

    // Payduty data Export to excel
    public function exportToExcelFromPayduty(){
        return Excel::download(new PaydutyExport, 'payduty.xlsx');
    }
}
