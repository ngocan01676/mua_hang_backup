<?php

namespace Zoe\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Storage;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->setRootControllerNamespace();
        if ($this->routesAreCached()) {
            $this->loadCachedRoutes();
        } else {
            $this->loadRoutes();
            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }

        $this->InitRouters();

    }

    public function InitRouters()
    {
        $config = config('zoe.router');
        if (isset($config['backend'])) {
            $this->InitRouter('backend', $this->app->_configs['routers']['backend'], $config['backend']);
        }
        if (isset($config['frontend']) && isset($this->app->_configs['routers']['frontend'])) {
            $this->InitRouter('frontend', $this->app->_configs['routers']['frontend'], $config['frontend']);
        }
    }

    public function InitRouter($guard, $routers, $config)
    {

        foreach ($routers as $name => $route) {
            if (isset($route['prefix'])) {
                $prefix = $route['prefix'];
            } else {
                $prefix = $config['prefix'];
            }
            $namespace = isset($route['namespace']) ? $route['namespace'] . '\\' : '';
            $controller = isset($route['controller']) ? $route['controller'] . '@' : '';
//            var_dump($route);

            foreach ($route['router'] as $key => $_route) {

                $method = ['get'];
                if (isset($_route['method'])) {
                    $method = $_route['method'];
                }

                $permission = $name . ':' . $key;
                if (isset($_route['name'])) {
                    $alias = $_route['name'];
                } else {
                    $alias = $guard . ":" . $permission;
                }
                if (isset($_route['action'])) {
                    $action = $namespace . $controller . $_route['action'];
                } else {
                    $action = $namespace . $controller . $key;
                }
                $link = isset($_route['link']) ? $_route['link'] : (isset($_route['url']) ? $prefix . $_route['url'] : "");
                if (empty($link)) {
                    continue;
                }
                $middleware = ["web"];
                $auth_guard = isset($_route["guard"]) ? $_route["guard"] : (isset($route["guard"]) ? $route["guard"] : $guard);

                if (!empty($auth_guard)) {
                    $middleware[] = 'auth:' . $auth_guard;
                    $acl = isset($_route["acl"]) ? ($_route["acl"] == true ? $permission : $_route["acl"]) : (isset($route["acl"]) ? $route["acl"] : "");

                    if (!empty($acl)) {
                        $middleware[] = "permission:" . $auth_guard . "-" . $acl;
                    }
                    if (!empty($acl)) {
                        if (!isset($this->app->permissions['data'][$auth_guard][$acl])) {
                            $this->app->permissions['data'][$auth_guard][$acl] = [];
                        }
                        $this->app->permissions['data'][$auth_guard][$acl][] = $alias;
                        $this->app->permissions['aliases'][$alias] = $acl;
                    }
                }
//                var_dump($method);
//                var_dump($auth_guard);
//                var_dump($link);
//                var_dump($action);
//                var_dump($alias);
//                echo "<BR>";
//                var_dump($middleware);
                if (isset($_route['form'])) {
                    $r = Route::match(['post'], $link . '-form', $namespace . $controller . "postCreate");
                    $r->name($alias . ":post");
                    $r->middleware($middleware);
                }
                $r = Route::match($method, $link, $action);
                $r->name($alias);
                $r->middleware($middleware);
            }
        }


//        die;
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}