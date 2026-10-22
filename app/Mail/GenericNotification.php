<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array{path: string, name: string}>  $fileAttachments
     */
    public function __construct(
        public string $mailSubject,
        public string $bodyHtml,
        public array $fileAttachments = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->mailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.layout',
            with: ['bodyHtml' => $this->bodyHtml],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return collect($this->fileAttachments)
            ->filter(fn ($a) => filled($a['path'] ?? null) && is_file($a['path']))
            ->map(fn ($a) => Attachment::fromPath($a['path'])->as($a['name'] ?? basename($a['path'])))
            ->all();
    }
}

