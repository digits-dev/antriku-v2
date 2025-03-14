<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EmailReceivePrintForm extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $filename = basename($this->pdfPath); // Get the actual file name

        return $this->subject('Signed Received Form PDF Copy')
            ->view('email.received_form', ['filename' => $filename]) // Pass filename to view
            ->attach(Storage::path($this->pdfPath));
    }
}
