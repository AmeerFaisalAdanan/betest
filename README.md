### Installation

1. Clone this repository
2. Run `composer install`
3. Run `php artisan key:generate`
4. Setup .env with relevant database and redis connection
5. Run `php artisan migrate`
6. Add cron job to your crontab using this command `(crontab -l 2>/dev/null; echo "* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1") | crontab -` .
7. View the application on the web browser
8. `/user` to view all users and delete a user, `/daily` to view daily transaction
