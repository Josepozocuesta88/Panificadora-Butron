<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Webklex\IMAP\Facades\Client;

use Carbon\Carbon;

class settingEmailController extends Controller
{

    public function index()
    {
        $client = Client::account('default');
        $client->connect();
        $sentFolder = $client->getFolder('Sent');

        // Correos enviados
        $emailsSent = $sentFolder->messages()->all()->get()->map(function ($message) {
            $to = $message->getTo()->first();

            // Fecha
            $date = $message->getDate();
            $dateFormatted = '';
            if ($date) {
                try {
                    $dateFormatted = \Carbon\Carbon::parse((string) $date)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $dateFormatted = (string) $date;
                }
            }

            // Flags comunes
            $flags = $message->getFlags();
            $state = 'No leído';
            if ($flags->contains('ANSWERED')) {
                $state = 'Respondido';
            } elseif ($flags->contains('SEEN')) {
                $state = 'Leído';
            } elseif ($flags->contains('RECENT')) {
                $state = 'Reciente';
            }

            // Direcciones
            $cc = $this->parseAddressList($message->getCc());
            $bcc = $this->parseAddressList($message->getBcc());
            $toMail = is_object($to) ? ($to->mail ?? '') : (string) $to;
            $toName = is_object($to) ? ($to->personal ?? '') : '';

            // Preparar body para el modal
            $bodyHtml = $message->getHTMLBody();
            if ($bodyHtml) {
                if (preg_match("/<body.*?>(.*)<\/body>/is", $bodyHtml, $matches)) {
                    $bodyHtml = $matches[1];
                }
            }

            $bodyText = $message->getTextBody() ?? strip_tags($bodyHtml);

            return (object)[
                'id'          => $message->getUid(),
                'subject'     => $message->getSubject(),
                'from'        => optional($message->getFrom()->first())->mail ?? '',
                'from_name'   => optional($message->getFrom()->first())->personal ?? '',
                'to'          => $toMail,
                'to_name'     => $toName,
                'cc'          => $cc,
                'bcc'         => $bcc,
                'attachments' => $message->getAttachments()->map(fn($att) => [
                    'name' => $att->name,
                    'size' => $att->size,
                    'type' => $att->content_type,
                ]),
                'state'       => $state,
                'flags'       => $flags->toArray(),
                'date'        => $dateFormatted,
                'size_kb'     => round($message->getSize() / 1024, 2),
                'has_error'   => stripos($message->getSubject(), 'Undelivered') !== false
                    || stripos($message->getSubject(), 'Mail Delivery Subsystem') !== false,
                'body_html'   => $bodyHtml,
                'body_text'   => $bodyText,
            ];
        });

        // Correos recibidos (bandeja de entrada)
        $inboxFolder = $client->getFolder('INBOX');
        $emailsInbox = $inboxFolder->messages()->all()->get()->map(function ($message) {
            $from = $message->getFrom()->first();

            // Fecha
            $date = $message->getDate();
            $dateFormatted = '';
            if ($date) {
                try {
                    $dateFormatted = \Carbon\Carbon::parse((string) $date)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $dateFormatted = (string) $date;
                }
            }

            // Flags comunes
            $flags = $message->getFlags();
            $state = 'No leído';
            if ($flags->contains('ANSWERED')) {
                $state = 'Respondido';
            } elseif ($flags->contains('SEEN')) {
                $state = 'Leído';
            } elseif ($flags->contains('RECENT')) {
                $state = 'Reciente';
            }

            // Direcciones
            $cc = $this->parseAddressList($message->getCc());
            $bcc = $this->parseAddressList($message->getBcc());
            $to = $message->getTo()->first();
            $toMail = is_object($to) ? ($to->mail ?? '') : (string) $to;
            $toName = is_object($to) ? ($to->personal ?? '') : '';

            // Preparar body para el modal
            $bodyHtml = $message->getHTMLBody();
            if ($bodyHtml) {
                if (preg_match("/<body.*?>(.*)<\/body>/is", $bodyHtml, $matches)) {
                    $bodyHtml = $matches[1];
                }
            }

            $bodyText = $message->getTextBody() ?? strip_tags($bodyHtml);

            return (object)[
                'id'          => $message->getUid(),
                'subject'     => $message->getSubject(),
                'from'        => is_object($from) ? ($from->mail ?? '') : (string) $from,
                'from_name'   => is_object($from) ? ($from->personal ?? '') : '',
                'to'          => $toMail,
                'to_name'     => $toName,
                'cc'          => $cc,
                'bcc'         => $bcc,
                'attachments' => $message->getAttachments()->map(fn($att) => [
                    'name' => $att->name,
                    'size' => $att->size,
                    'type' => $att->content_type,
                ]),
                'state'       => $state,
                'flags'       => $flags->toArray(),
                'date'        => $dateFormatted,
                'size_kb'     => round($message->getSize() / 1024, 2),
                'has_error'   => stripos($message->getSubject(), 'Undelivered') !== false
                    || stripos($message->getSubject(), 'Mail Delivery Subsystem') !== false,
                'body_html'   => $bodyHtml,
                'body_text'   => $bodyText,
            ];
        });

        // Puedes pasar ambos arrays a la vista
        return view('pages.settings.setting-email', [
            'emailsSent' => $emailsSent,
            'emailsInbox' => $emailsInbox,
        ]);

        return view('pages.settings.setting-email', compact('emails'));
    }

    private function parseAddressList($addresses)
    {
        return collect($addresses ?? [])->map(function ($addr) {
            if (is_object($addr)) {
                // Caso normal: objeto Address
                return $addr->mail ?? (string) $addr;
            }

            if (is_array($addr)) {
                // Si es un array, buscamos las claves comunes
                return $addr['mail']
                    ?? $addr['address']
                    ?? implode(', ', $addr); // fallback: concatenar
            }

            // Si ya es string
            return (string) $addr;
        })->toArray();
    }
}
