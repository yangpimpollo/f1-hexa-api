# Configuración de proyecto
```bash
laravel new f1-hexa-api
cd f1-hexa-api
php artisan install:api
composer require dedoc/scramble
php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"

#-- composer.json -----------------------------------------------------
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "yangpimpollo\\": "_src/"
        }
#----------------------------------------------------------------------


composer dump-autoload


#-- bootstrap/app.php -------------------------------------------------
    api: __DIR__.'/../_src/L3_infrastructure/Routes/my_api.php',

#-- bootstrap/providers.php -------------------------------------------
    use yangpimpollo\L3_infrastructure\Providers\myServiceProvider;
    myServiceProvider::class,


# crear _src [L1_domain, L2_application, L3_infrastructure]


#-- L3_infrastructure/Providers/myServiceProvider ---------------------
    use Dedoc\Scramble\Scramble;
    use Dedoc\Scramble\Support\Generator\OpenApi;
    use Dedoc\Scramble\Support\Generator\SecurityScheme;
    public function boot(): void
    {
        // para que reconozca el token bearer en scramble
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure( SecurityScheme::http('bearer') );
        });
#----------------------------------------------------------------------

# clean migrations cache, jobs

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


#-- config/auth.php --------------------------------------------------
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => yangpimpollo\L3_infrastructure\Model\my_user::class,
        ],
#----------------------------------------------------------------------

BD para test en phpunit.xml
        <env name="DB_CONNECTION" value="pgsql"/>
        <env name="DB_DATABASE" value="f1_hexa_api-test"/>
```

```bash
# LUEGO DE CLONAR PROYECTO
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```



# Acerca de las Excepciones
0. para registrar en `bootstrap/app.php`
```php
use yangpimpollo\L1_domain\Exceptions\my_invalid_dni_Exception;

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (my_invalid_dni_Exception $e) {
            return response()->json([
                'status' => 'error_de_dominio',
                'mensaje' => $e->getMessage()
            ], 400);
        });
```
1. tenemos una ruta en api-route para probar
```php
Route::get('/test-dni/{valor}', function ($valor) {
    $objetoDni = new dni($valor); 
    return response()->json(['dni' => $objetoDni->value()]);
});
```
2. enviamos `http://127.0.0.1:8000/api/test-dni/{valor}` valores incorrectos para lanzar la excepcion obtendremos resultados diferentes

3. MODO:  no debug - sin registrar
```json
500 Internal Server Error
    {
    "message": "Server Error"
    }
```
4. MODO:  debug - sin registrar
```json
500 Internal Server Error
    {
    "message": "🙄❌❌ El DNI '1234567' debe tener exactamente 8 dígitos.",
    "exception": "yangpimpollo\\L1_domain\\Exceptions\\my_invalid_dni_Exception",
    "file": "/home/yangpimpollo/Laravel_repo/f1-hexa-api/_src/L1_domain/Exceptions/my_invalid_dni_Exception.php",
    "line": 11,
    "trace": [
        {
        "file": "/home/yangpimpollo/Laravel_repo/f1-hexa-api/_src/L1_domain/ValueObjects/dni.php",
        "line": 20,
        "function": "invalidLength",
        "class": "yangpimpollo\\L1_domain\\Exceptions\\my_invalid_dni_Exception",
        "type": "::"
        ...
        }
    }
```

5. MODO:  debug|no debug - registrado en bootstrap/app.php withExceptions
```json
400 Bad Request
    {
    "status": "error_de_dominio",
    "mensaje": "🙄❌❌ El DNI '1234567' debe tener exactamente 8 dígitos."
    }
```


