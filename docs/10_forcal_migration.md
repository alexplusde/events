
# Migration von REDAXO Forcal (ehem. Sked)

Folgende SQL-Befehle (Quick & Dirty umgesetzt) dürften helfen bei der Übertragung der Daten:

```sql
INSERT INTO rex_event_date
SELECT
id AS id,
name_1 AS name,
teaser_1 AS teaser,
text_1 AS description,
lang_1 AS lang_id,
category AS event_category_id,
start_date AS startDate,
start_time AS startTime,
full_time AS all_day,
start_time AS doorTime,
end_time AS endTime,
venue AS location,
end_date AS endDate,
id as space,
image AS image_poster,
image AS images,
id as url,
id as video_url,
status AS eventStatus,
uid AS uid,
updateuser AS updateuser,
createuser AS createuser,
updatedate AS updatedate,
createdate AS createdate,
id AS startDateTime
FROM rex_sked_entries
```

```sql
INSERT INTO rex_event_category
SELECT
id as id,
id as prio,
name_1 as name,
color as icon,
name_1 as teaser,
description_1 as description,
status as images,
status as status,
updateuser AS updateuser,
createuser AS createuser
FROM rex_sked_categories
```

```sql
INSERT INTO rex_event_location
SELECT
id as id,
id as google_places,
id as location_category_id,
name_1 as name,
street as street,
zip as zip,
city as locality,
country as countrycode,
id as lat,
id as lng,
updateuser AS updateuser,
createuser AS createuser
FROM rex_sked_venues
```

```sql
update rex_event_date set space = 0, url = "", video_url = "", startDateTime = 0000-00-00;
update rex_event_category set images = "";
update rex_event_location set google_places = "", location_category_id = "", lat = "", lng = "";
```
