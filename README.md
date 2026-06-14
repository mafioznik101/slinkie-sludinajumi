<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

MYSQL 8.2.0 3306 <br>
NGINX 1.25.3 80, 443 <br>
PHP 8.3.1 830 <br>

cd C:\wamp64\www <br>
git clone https://github.com/mafioznik101/slinkie-sludinajumi.git <br>
cd slinkie-sludinajumi <br>
composer install <br>
cp .env.example .env <br>
← pielabot .env (DB_CONNECTION=mysql, DB_DATABASE=slinkie, DB_USERNAME=root, DB_PASSWORD=) <br>
← phpMyAdmin → izveidot tukšu datubāzi "slinkie" <br>
php artisan key:generate <br>
php artisan migrate --seed <br>
php artisan storage:link <br>
npm install <br>
npm run build <br>

DB_CONNECTION=mysql <br>
DB_HOST=127.0.0.1 <br>
DB_PORT=3306 <br>
DB_DATABASE=slinkie <br>
DB_USERNAME=root <br>
DB_PASSWORD= <br>

1. Izpako uz C:\wamp64\www\ <br>
2. Pielabo .env → DB_DATABASE, DB_PASSWORD ja vajag <br>
3. php artisan migrate --seed <br>
4. php artisan storage:link <br>
5. php artisan serve <br>
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
