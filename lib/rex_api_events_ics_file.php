<?php

class rex_api_events_ics_file extends rex_api_function
{
    protected $published = true;  // Aufruf aus dem Frontend erlaubt

    public function execute(): void
    {
        $event_id = rex_request('id', 'int', 0);
        if (!$event_id) {
            $result = [ 'errorcode' => 1, rex_i18n::msg('rex_api_events_ics_file_no_id') ];
            self::httpError($result);
        } else {
            /** @var $event event_date */
            $event = event_date::get($event_id);
            $ics_filename = $event->getName();
            header('Content-Type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $ics_filename . '.ics"');

            exit($event->getIcs());
        }
    }

    public static function httpError(string $result): void
    {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        exit(json_encode($result));
    }
}
