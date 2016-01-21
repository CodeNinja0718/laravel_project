<?php

namespace Encore\Admin\Providers;

use Encore\Admin\Auth\AuthManager;
use Encore\Admin\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        'InstallCommand',
        'MakeCommand',
        'MenuCommand'
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => \Encore\Admin\Middleware\Authenticate::class,
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path('admin.php'), ], 'config');

        $this->publishes([__DIR__ . '/../../migrations/' => base_path('/database/migrations'), ], 'migrations');

        if (file_exists($routes = admin_path('routes.php')))
        {
            require $routes;

            $this->app['admin.router']->register();
        }

        if (file_exists($menu = admin_path('menu.php')))
        {
            $menu = require $menu;
            config(['admin.menu' => $menu]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ .'/../../views', 'admin');

        $this->app->booting(function () {
            $loader  =  AliasLoader::getInstance();

            $loader->alias('Admin', \Encore\Admin\Facades\Admin::class);
        });

        $this->app->bindShared('admin.auth', function($app)
        {
            return new AuthManager($app);
        });

        $this->setupClassAliases();
        $this->registerRouteMiddleware();
        $this->registerCommands();

        $this->registerRouter();
    }

    /**
     * Setup the class aliases.
     *
     * @return void
     */
    protected function setupClassAliases()
    {
        $aliases = [
//            'admin.grid'    => \Encore\Admin\Grid::class,
//            'admin.form'    => \Encore\Admin\Form::class,
//            'admin.chart'   => \Encore\Admin\Chart::class,

            'admin.router'  => \Encore\Admin\Routing\Router::class,
        ];

        foreach ($aliases as $key => $alias) {
            $this->app->alias($key, $alias);
        }
    }

    public function registerRouter()
    {
        $this->app->singleton('admin.router', function($app) {
            return new Router($app['router']);
        });
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->middleware($key, $middleware);
        }
    }

    /**
     * Register the commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach ($this->commands as $command)
        {
            $this->commands('Encore\Admin\Commands\\' . $command);
        }
    }
}