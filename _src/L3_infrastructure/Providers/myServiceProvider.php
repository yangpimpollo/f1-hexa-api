<?php

namespace yangpimpollo\L3_infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;




use yangpimpollo\L1_domain\Repository\AuthRepositoryInterface;
use yangpimpollo\L1_domain\Repository\CustomerRepositoryInterface;
use yangpimpollo\L1_domain\Repository\ProductRepositoryInterface;
use yangpimpollo\L3_infrastructure\Persistence\EloquentAuth;
use yangpimpollo\L3_infrastructure\Persistence\EloquentCustomer;
use yangpimpollo\L3_infrastructure\Persistence\EloquentSearchProduct;


class myServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, EloquentAuth::class);
        $this->app->bind(CustomerRepositoryInterface::class, EloquentCustomer::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentSearchProduct::class);
    }

    public function boot(): void
    {
        // para que reconozca el token bearer en scramble
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure( SecurityScheme::http('bearer') );
        });
    }
}
