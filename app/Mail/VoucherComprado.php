<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherComprado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $voucher,
        public $voucherDetalle
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu voucher de Vauchis',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.voucher-comprado',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $nombreArchivo = 'voucher-' . $$this->voucherDetalle->vd_id . '.pdf';
        $rutaRelativa = 'vouchers/pdf/' . $nombreArchivo;

        return [
            Attachment::fromPath(
                storage_path('app/public/' . $rutaRelativa)
            )
            ->as('voucher.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
