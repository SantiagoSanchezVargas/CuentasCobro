<?php

namespace App\Mail;

use App\Models\CuentaCobro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class CuentaCobroNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $cuenta;
    public $mensaje;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(CuentaCobro $cuenta, string $mensaje, ?string $pdfPath = null)
    {
        $this->cuenta = $cuenta;
        $this->mensaje = $mensaje;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificación Cuenta de Cobro #' . $this->cuenta->numero,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cuenta_cobro_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('CuentaCobro_' . $this->cuenta->numero . '.pdf')
                ->withMime('application/pdf');
        }
        return $attachments;
    }
}
