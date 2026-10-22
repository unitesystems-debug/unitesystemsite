<?php

namespace App\Services;

use App\Mail\GenericNotification;
use App\Models\EmailLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Notifier
{
    /**
     * Send a styled HTML email to one or more recipients, logging the result
     * to the admin "Email Outbox" regardless of success or failure.
     *
     * @param  array<int, string>|string  $to
     * @param  array<int, array{path: string, name: string}>  $attachments
     * @param  array{0: string, 1: string}|null  $replyTo  [email, name]
     */
    public static function send(array|string $to, string $subject, string $bodyHtml, array $attachments = [], ?array $replyTo = null): void
    {
        $recipients = array_values(array_filter(array_map('trim', is_array($to) ? $to : [$to])));

        foreach ($recipients as $address) {
            try {
                $mailable = (new GenericNotification($subject, $bodyHtml, $attachments));

                if ($replyTo) {
                    $mailable->replyTo($replyTo[0], $replyTo[1] ?? null);
                }

                Mail::to($address)->send($mailable);

                EmailLog::create([
                    'to_address' => $address,
                    'subject' => $subject,
                    'body' => $bodyHtml,
                    'status' => 'sent',
                ]);
            } catch (Throwable $e) {
                report($e);

                EmailLog::create([
                    'to_address' => $address,
                    'subject' => $subject,
                    'body' => $bodyHtml,
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /** Notify the admin team using the configured notification email(s). */
    public static function notifyAdmin(string $subject, string $title, array $rows, array $attachments = [], ?array $replyTo = null): void
    {
        $to = array_filter(array_map('trim', explode(',', Setting::get('notify_email', 'admin@example.com'))));

        self::send($to, $subject, self::heading($title).self::table($rows), $attachments, $replyTo);
    }

    public static function heading(string $title): string
    {
        return '<h2 style="margin:0 0 16px;font-size:19px;color:#14264F;">'.e($title).'</h2>';
    }

    /** @param array<string, string> $rows */
    public static function table(array $rows): string
    {
        $html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">';

        foreach ($rows as $label => $value) {
            $html .= '<tr>'
                .'<td style="padding:6px 12px 6px 0;color:#4A5875;font-size:13px;vertical-align:top;white-space:nowrap;">'.e($label).'</td>'
                .'<td style="padding:6px 0;color:#14264F;font-size:14px;">'.nl2br(e((string) $value)).'</td>'
                .'</tr>';
        }

        return $html.'</table>';
    }
}
