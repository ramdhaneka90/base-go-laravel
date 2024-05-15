<?php namespace App\Providers;

/**
* ServiceProvider
*
* The service provider for the modules. After being registered
* it will make sure that each of the modules are properly loaded
* i.e. with their routes, views etc.
*
* @author Kamran Ahmed <kamranahmed.se@gmail.com>
* @package App\Modules
*/
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    private $list_modules = [];

    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = config("modules");
        $this->getModule($modules);
    }

    private function getModule($modules, $main = '')
    {
        $path = !empty($main) ? $main . DIRECTORY_SEPARATOR : '';
        if (is_array($modules)) {
            foreach ($modules as $key => $module) {
                
                if (is_array($module)) {
                    $this->getModule($module, $path . $key);
                } else {
                    if (is_string($key)) {
                        $this->setModule($path . $key . DIRECTORY_SEPARATOR . $module);
                    } else {
                        $this->setModule($path . $module);
                    }
                }
            }
        } else {
            
            $this->setModule($path . $modules);
        }
    }

    private function setModule($module)
    {
        
        // // Load the routes for each of the modules
        // $route_file = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Modules', $module, 'routes.php']);
        // if(file_exists($route_file)) {
        //     include $route_file;
        //     $this->list_modules['route_file'][] = $route_file; // enable me if you need show list module
        // }

        // Load the views
        $view_dir = app_path(implode(DIRECTORY_SEPARATOR, ['Modules', $module, 'Views']));
           
        if(is_dir($view_dir)) {
            $re = '/
                  (?<=[a-z])
                  (?=[A-Z])
                | (?<=[A-Z])
                  (?=[A-Z][a-z])
                /x';
            $alias = preg_split($re, $module);
            
            $this->loadViewsFrom($view_dir, strtolower(implode('-', $alias)));
            $this->list_modules['view_dir'][] = $view_dir; // enable me if you need show list module
        }
    }

    public function register() {}

}
