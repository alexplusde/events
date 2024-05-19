# ICS Kalenderdaten

## Import von ICS-Kalendern (dev)

Events kommt mit einem eigenen Cronjob zum importieren von ics-Kalendern aus dem Internet. Das Cronjob-Addon aufrufen, einen neuen Cronjob anlegen und den Instruktionen folgen.

## Export eines einzelnen Termins als ics-Datei (dev)

Events kommt mit einer eigenen rex_api-Schnittstelle für den Export von einzelnen Terminen. `?rex-api-call=events_ics_file&id=2` aufrufen, um eine ICS-Datei anhand des Termins mit der `id=2` zu erzeugen.
