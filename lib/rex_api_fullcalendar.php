<?php

class rex_api_fullcalendar extends rex_api_function
{
    protected $published = true;

    public function execute(): void
    {
        $events = event_date::query()->find();
        foreach ($events as $event) {
            $result[] = ["title" => $event->name, "start"  => $event->startDate, "end"  => $event->endDate,
            "url" => "/redaxo/index.php?page=events/date&table_name=rex_event_date&rex_yform_manager_popup=0&data_id=".$event->id."&func=edit"];
        }

        header('Content-Type: application/json; charset=UTF-8');
        exit(json_encode($result));
    }

    public static function httpError(string $result): void
    {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        echo "test";
        exit(json_encode($result));
    }
}
