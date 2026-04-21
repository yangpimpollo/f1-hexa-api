

laravel new f1-hexa-api
cd f1-hexa-api


php artisan install:api

composer require dedoc/scramble
php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"

composer.json
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "yangpimpollo\\": "_src/"
        }

composer dump-autoload

bootstrap/app.php
    api: __DIR__.'/../_src/L3_infrastructure/Routes/my_api.php',

bootstrap/providers.php
    use yangpimpollo\L3_infrastructure\Providers\myServiceProvider;
    myServiceProvider::class,


_src [L1_domain, L2_application, L3_infrastructure]


L3_infrastructure/Providers/myServiceProvider
    use Dedoc\Scramble\Scramble;
    use Dedoc\Scramble\Support\Generator\OpenApi;
    use Dedoc\Scramble\Support\Generator\SecurityScheme;
    public function boot(): void
    {
        // para que reconozca el token bearer en scramble
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure( SecurityScheme::http('bearer') );
        });


clean migrations

.env
.env.example

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=f1_hexa_api
DB_USERNAME=postgres
DB_PASSWORD=root



php artisan migrate
php artisan serve



config/auth.php
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => yangpimpollo\L3_infrastructure\Model\my_user::class,
        ],










composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve