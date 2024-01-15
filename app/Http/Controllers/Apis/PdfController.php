<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apis\SendemailRequest;
use App\Mail\PdfEmail;
use App\Models\Apis\Job;
use App\Models\Apis\Payduty;
use App\Models\Apis\Rigger;
use App\Models\Apis\Transportation;
use Illuminate\Support\Facades\Mail;
use PDF;
use Swift_TransportException;

class PdfController extends Controller
{
    public function generatePdf($id, $isRigger = false)
    {
        $pdfOptions = [
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];
        if ($isRigger === true) {

            $data = Rigger::where('id', $id)->first();

            $pdf = PDF::loadView('pdf.riggerpayduty', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);

            // Saving PDF to the directory.
            $pdfData = [
                'folder_name' => 'riggertickets',
                'file_name' => $data->ticketNumber,
                'file_type' => 'riggerpayduty-pdf',
                'file_ext' => 'pdf'
            ];

            $pdfPath = Fileupload::pdfUpload($pdf, $pdfData['folder_name'], $pdfData['file_name']);

            // Storing the PDF path inside the db.
            $saveInDb = Helper::addFile($pdfPath, $pdfData['file_type'], $pdfData['file_ext'], 0, $data->account_id, $data->id, 0, 0);


            // Setup the PDF path based on the enviroment.
            if (app()->isLocal()) {
                $getFullPath = $saveInDb['data']->base_url . $saveInDb['data']->file_url;
            } else {
                $getFullPath = $saveInDb['data']->base_url . 'storage/' . $saveInDb['data']->file_url;
            }

            // Add this URL to the rigger PDF field in Job Model.
            Job::where('id', $data->job_id)->update(['pdf_rigger' => $getFullPath]);

            return [
                "status" => 200,
                "message" => "Rigger PDF generated successfully.",
                "pdf" => $getFullPath,
                "id" => $data->id
            ];
        } else {

            $data = Transportation::where('id', $id)->first();

            $pdf = PDF::loadView('pdf.transportation', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);

            // Saving PDF to the directory.
            $pdfData = [
                'folder_name' => 'transportationtickets',
                'file_name' => $data->ticketNumber,
                'file_type' => 'transportation-pdf',
                'file_ext' => 'pdf'
            ];

            $pdfPath = Fileupload::pdfUpload($pdf, $pdfData['folder_name'], $pdfData['file_name']);

            // Storing the PDF path inside the db.
            $saveInDb = Helper::addFile($pdfPath, $pdfData['file_type'], $pdfData['file_ext'], 0, $data->account_id, 0, $data->id, 0);

            // Setup the PDF path based on the enviroment.
            if (app()->isLocal()) {
                $getFullPath = $saveInDb['data']->base_url . $saveInDb['data']->file_url;
            } else {
                $getFullPath = $saveInDb['data']->base_url . 'storage/' . $saveInDb['data']->file_url;
            }

            // Add this URL to the rigger PDF field in Job Model.
            Job::where('id', $data->job_id)->update(['pdf_transportation' => $getFullPath]);

            return [
                "status" => 200,
                "message" => "Transportation PDF generated successfully.",
                "pdf" => $getFullPath,
                "id" => $data->id
            ];
        }
    }

    // Send to Email: Rigger & Payduty PDF
    public function sendToEmail($email, $id, $isRigger)
    {
        $riggerId = $id;
        $email = $email;
        if ($isRigger === true) {
            $getRiggerTicket = Rigger::where('id', $riggerId)->first();
            $getRiggerTicketPdfId = Rigger::where('id', $riggerId)->first()->getRiggerPayduty->id ?? null;
            if ($getRiggerTicketPdfId != null) {
                if (app()->isLocal()) {
                    $pdfPath = public_path($getRiggerTicket->getRiggerPayduty->file_url);
                } else {
                    $pdfPath = storage_path($getRiggerTicket->getRiggerPayduty->file_url);
                }

                $data = [
                    'data' => $getRiggerTicket,
                    'pdf' => $pdfPath,
                    'subject' => 'Rigger Ticket',
                    'isRigger' => $isRigger
                ];
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email Not send No rigger PDF found.',
                    'recipent' => $email
                ], 404);
            }
        } else {
            $getTransportationTicket = Transportation::where('id', $id)->first();
            $getTransportationTicketPdfId = Transportation::where('id', $id)->first()->getTransportationTicketPdf->id ?? null;

            if ($getTransportationTicketPdfId != null) {
                if (app()->isLocal()) {
                    $pdfPath = public_path($getTransportationTicket->getTransportationTicketPdf->file_url);
                } else {
                    $pdfPath = storage_path($getTransportationTicket->getTransportationTicketPdf->file_url);
                }

                $data = [
                    'data' => $getTransportationTicket,
                    'pdf' => $pdfPath,
                    'subject' => 'Transportation Ticket',
                    'isRigger' => $isRigger
                ];
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email Not send No transportation PDF found.',
                    'recipent' => $email
                ], 404);
            }
        }

        // Try sending an email and handle exceptions
        try {
            Mail::to($email)->send(new PdfEmail($data));
        } catch (Swift_TransportException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Email sending is disabled because the mailer is not configured to use SMTP.',
                'link' => 'No PDF Found'
            ], 404);
        }
        return [
            'status' => 200,
            'message' => 'Email sent with attachement successfully.',
            'recipent' => $email
        ];
    }


    // Generate PDF then save and Send it to email.
    public function generatePdfAndSendEmail(SendemailRequest $request, $id)
    {
        $email = $request->email;
        $isRigger = $request->isRigger ?? null;

        $pdfPath = $this->generatePdf($id, $isRigger);

        if ($pdfPath['status'] === 200) {
            $success = $this->sendToEmail($email, $pdfPath['id'], $isRigger);

            if ($success['status'] === 200) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Email sent with attachment successfully.',
                    'recipient' => $email,
                    'pdf' => $pdfPath['pdf']
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email sending failed.',
                    'recipient' => $email
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'PDF generation failed.',
                'recipient' => $email
            ], 404);
        }
    }


    // Export to PDF for Rigger
    public function clickToGetRiggerPdf($id = null) {
        
        $pdfOptions = [
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];
        if ($id != null) {

            $data = Rigger::where('id', $id)->first();

            $pdf = PDF::loadView('pdf.riggerpayduty', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);
            
            return $pdf->download($data->ticketNumber.'.pdf');
        }
        else {
            return [
                'status' => 200,
                'message' => 'Ticket Id is required as a parameter.'
            ];
        }
    }

    // Export to PDF for Transportation
    public function clickToGetTransportationPdf($id = null) {
        
        $pdfOptions = [
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];
        if ($id != null) {

            $data = Transportation::where('id', $id)->first();

            $pdf = PDF::loadView('pdf.transportation', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);
            
            return $pdf->download($data->ticketNumber.'.pdf');
        }
        else {
            return [
                'status' => 200,
                'message' => 'Ticket Id is required as a parameter.'
            ];
        }

    }

    // Export to PDF for Payduty
    public function clickToGetPaydutyPdf($id = null) {
        
        $pdfOptions = [
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];
        if ($id != null) {

            $riggerId = Payduty::where('id',$id)->value('rigger_id');

            $data = Rigger::where('id', $riggerId)->first();

            $pdf = PDF::loadView('pdf.riggerpayduty', ['data' => $data])->setPaper('A4', 'landscape')->setOption($pdfOptions);
            
            return $pdf->download($data->ticketNumber.'.pdf');
        }
        else {
            return [
                'status' => 200,
                'message' => 'Payduty Id is required as a parameter.'
            ];
        }

    }
}
