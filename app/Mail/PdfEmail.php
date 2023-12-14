<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PdfEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->pdfPath = $data['pdf'];
        $this->data = $data['data'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rigger Ticket')->view('emails.pdf_email')->attach($this->pdfPath, [
            'mime' => 'application/pdf',
        ]);
    }
}
