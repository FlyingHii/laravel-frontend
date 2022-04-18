<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{

    /**
     * registerModules
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->getModules() as $module => $value) {
            if (!$value) continue;
            $this->registerModuleMigrations($module);
            $this->mapModuleRoutes($module);
            $this->defineNamespaceModuleViews($module);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return array
     */
    public function getModules(): array
    {
        return File::directories(__DIR__ . '/../Modules/');
    }

    /**
     * Register paths to be published by the publish command.
     *
     * @param string $module
     * @return void
     */
    protected function registerModuleMigrations(string $module): void
    {
        $this->loadMigrationsFrom(module_path($module . DIRECTORY_SEPARATOR . 'Migrations'));
    }

    /**
     * Define the "module" routes for the application.
     *
     * @param string $module
     * @return void
     */
    protected function mapModuleRoutes(string $module): void
    {
        $namespace = str_replace('/', '\\', $module);

        $routerWebPath = module_path($module . DIRECTORY_SEPARATOR . 'Routers/web.php');
        $routerApiPath = module_path($module . DIRECTORY_SEPARATOR . 'Routers/api.php');

        if (file_exists($routerWebPath)) {
            $this->mapWebRoutes($namespace, $routerWebPath);
        }

        if (file_exists($routerApiPath)) {
            $this->mapApiRoutes($namespace, $routerApiPath);
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @param $namespace
     * @param  $path
     * @return void
     */
    protected function mapApiRoutes($namespace, $path)
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace("App\Modules\\{$namespace}\\Controllers")
            ->group($path);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *  @param $namespace
     * @param  $path
     * @return void
     */
    protected function mapWebRoutes($namespace, $path)
    {
        Route::middleware('web')
            ->namespace("App\Modules\\{$namespace}\\Controllers")
            ->group($path);
    }

    /**
     * Define namespace the "module" views for the application.
     *
     * @param string $module
     * @return void
     */
    protected function defineNamespaceModuleViews(string $module): void
    {
        $this->loadViewsFrom(module_path($module . DIRECTORY_SEPARATOR . 'Views'), $module);
    }
}

