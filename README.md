# Car Service
PHP: 8.3 <br>
Laravel: 10.48.7

# Installation
1. #git clone https://github.com/raczmarco3/car-service.git
2. #cd car-service/backend
3. #composer install
4. #cp .env.example .env
5. #php artisan key:generate
6. add database connection info to env:<br> example.: <br>
   DB_CONNECTION=mysql<br>
   DB_HOST=mysql<br>
   DB_PORT=3306<br>
   DB_DATABASE=carservice<br>
   DB_USERNAME=user<br>
   DB_PASSWORD=password<br>
7. #./vendor/bin/sail up
8. In the webserver's docker container run:<br> #php artisan app:check-database
9. Wait for the migration to complete and for the database tables to be populated with data
10. Open frontend/index.html

# Requirements
- Composer
- MySQL or MariaDB
- PHP >= 8.1
- Docker
- WSL 2