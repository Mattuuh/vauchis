<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherRegaloMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $voucher,
        public $voucherDetalle,
        public $rutaPdf
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nombreRemitente = $this->voucherDetalle->vd_variante_nombre_de;

        return new Envelope(
            subject: "{$nombreRemitente} te envió un regalo 🎁",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.voucher-regalo',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $nombre_archivo = 'voucher_para_' . $this->voucherDetalle->vd_variante_nombre_para . '.pdf';

        return [
            Attachment::fromPath(
                storage_path('app/public/' . $this->rutaPdf)
            )
            ->as($nombre_archivo)
            ->withMime('application/pdf'),
        ];
    }
}
