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

    public $zipPath;
    public $zipFileName;
    public $zipPassword;

    /**
     * Create a new message instance.
     */
    public function __construct($zipPath, $zipFileName, $zipPassword)
    {
        $this->zipPath = $zipPath;
        $this->zipFileName = $zipFileName;
        $this->zipPassword = $zipPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Signed Received Form - Encrypted PDF')
            ->view('email.received_form', [
                'zipFileName' => $this->zipFileName,
                'zipPassword' => $this->zipPassword
            ])
            ->attach(Storage::path('temp_pdfs/' . $this->zipFileName), [
                'as' => $this->zipFileName,
                'mime' => 'application/zip',
            ]);
    }
}

