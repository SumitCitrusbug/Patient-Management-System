----------------------------------run the project steps----------------------------------------------------------------

1.in .env file generate key
--php artisan key:generate

2. install composer if vendor folder not present
   -- composer install

3. run the migration
   -- php artisan migrate

4. if you drop tables
   --php artisan passport:client --personal

5. seeding database
   --php artisan db:seed

6. run the project
   --php artisan serve

7. stripe cli

--stripe listen --forward-to http://127.0.0.1:8000/api/webhook

8. run scheduler

--php artisan schedule:work
