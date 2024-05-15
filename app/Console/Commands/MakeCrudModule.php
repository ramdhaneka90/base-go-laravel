<?php

namespace App\Console\Commands;

use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class MakeCrudModule extends Command
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new module with CRUD function';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Get the stub file for the generator.
     *
     * @return array
     */
    protected function getStubPath()
    {
        return [
            'Controller' => app_path() . '/Console/Commands/Stubs/Module/Controller.stub',
            'Service' => app_path() . '/Console/Commands/Stubs/Module/Service.stub',
            'Index' => app_path() . '/Console/Commands/Stubs/Module/Views/Index.stub',
            'Form' => app_path() . '/Console/Commands/Stubs/Module/Views/Form.stub',
        ];
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        $className = $this->getSingularClassName($this->argument('name'));

        return [
            'CLASS_NAME' => $className,
            'MODULE_NAME' => lcfirst($className),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile($key)
    {
        return $this->getStubContents($this->getStubPath()[$key], $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class controller
     *
     * @return array
     */
    public function getSourceFilePath()
    {
        $className = $this->getSingularClassName($this->argument('name'));

        return [
            'Controller' => base_path('App' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers') . DIRECTORY_SEPARATOR . $className . 'Controller.php',
            'Service' => base_path('App' . DIRECTORY_SEPARATOR . 'Services') . DIRECTORY_SEPARATOR . $className . 'Service.php',
            'Index' => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages') . DIRECTORY_SEPARATOR . lcfirst($className) . DIRECTORY_SEPARATOR . 'index.blade.php',
            'Form' => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages') . DIRECTORY_SEPARATOR . lcfirst($className) . DIRECTORY_SEPARATOR . 'form.blade.php',
        ];
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Build final module files
     *
     * @param  string $key
     * @param  string $path
     * @return void
     */
    protected function generateFile($key, $path)
    {
        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile($key);

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Execute the console command.
     *w
     * @return int
     */
    public function handle()
    {
        $paths = $this->getSourceFilePath();

        foreach ($paths as $key => $path) {
            $this->generateFile($key, $path);
        }
    }
}
