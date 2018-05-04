<?php

namespace HiHaHo\Saml;

use HiHaHo\Saml\Console\CreateSamlConfigCommand;
use HiHaHo\Saml\Console\GetSamlConfigCommand;
use HiHaHo\Saml\Console\ListSamlConfigsCommand;
use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlSecurity;
use HiHaHo\Saml\OneLogin\OneLoginSaml2Auth;
use HiHaHo\Saml\Transformers\SamlConfigTransformer;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Spatie\Fractal\Fractal;
use Spatie\Fractalistic\ArraySerializer;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPackageConfigPath(), 'saml-dsp');

        $this->registerSamlContainer();

        $this->registerOneLoginSamlContainer();
    }

    protected function registerSamlContainer()
    {
        $this->app->singleton('saml.database.exists', function() {
            return Schema::hasTable(SamlConfig::getTableName());
        });

        $this->app->bind('samlConfigTransformed', function(Container $app) {
            $request = $app->make(\Illuminate\Http\Request::class);
            $samlConfigTableExists = $app->make('saml.database.exists');

            if (!$samlConfigTableExists) {
                return;
            }

            $samlConfig = SamlConfig::whereSlug($request->route('samlConfig'))->first();

            if (!isset($samlConfig)) {
                return;
            }

            $configTransformed = $this->app->make(Fractal::class)::create()
                ->item($samlConfig)
                ->transformWith(new SamlConfigTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray();

//            dd($configTransformed);

            return $configTransformed;
        });
    }

    protected function registerOneLoginSamlContainer()
    {
        $this->app->bind(OneLoginSaml2Auth::class, function (Container $app) {
            $samlConfig = $app->make('samlConfigTransformed');

            if (!isset($samlConfig)) {
                return;
            }

            return new OneLoginSaml2Auth($samlConfig);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getPackageConfigPath() => config_path('saml-dsp.php')
            ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../migrations');

            $this->commands([
                CreateSamlConfigCommand::class,
                ListSamlConfigsCommand::class,
                GetSamlConfigCommand::class,
            ]);
        }
    }

    protected function loadRoutes()
    {
        if (!config('saml-dsp.register_routes', true)) {
            return;
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    protected function getPackageConfigPath()
    {
        return __DIR__.'/../config/saml-dsp.php';
    }
}
