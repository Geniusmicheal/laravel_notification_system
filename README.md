How to configuture your application

open  ".env" file at the root folder and edit DB_PASSWORD and DB_USERNAME to your mysql system database password and username
create mysql database call "notificationsystem"

copy this code "php artisan migrate" on your terminal
follow by this code "php artisan db:seed" on your terminal
start serve  with "php artisan serve"
on 'notificationsystem.topic' table  select a slug value for topic slug

Api endpoint
POST http://127.0.0.1:8000/api/subscribe/{topic_slug}  (Example: http://127.0.0.1:8000/api/subscribe/Mollitia_fugiat_fugiat_quibusdam_alias_non.);
POST http://127.0.0.1:8000/api/publish/{topic_slug} (Example: http://127.0.0.1:8000/api/subscribe/Mollitia_fugiat_fugiat_quibusdam_alias_non.)

For the HTTP notification, check the 'notificationsystem.notifications' table for the sent notification message.






