<?php

namespace Giangmv\LaravelApiGenerator;

use Illuminate\Support\Str;

class LaravelApiGenerator
{
    const STUB_DIR = __DIR__.'/resources/stubs/';
    protected $model;
    protected $module;
    protected $result = false;

    public function __construct(string $model, string $module)
    {
        $this->model = $model;
        $this->module = $module;
        self::generate();
    }

    public function generate()
    {
        self::directoryCreate();
    }

    public function directoryCreate()
    {
        if (! file_exists(base_path('app/Http/Controllers/Api'))) {
            mkdir(base_path('app/Http/Controllers/Api'));
        }
        if (! file_exists(base_path('app/Http/Repositories'))) {
            mkdir(base_path('app/Http/Repositories'));
        }
    }

    public function generateController()
    {
        $this->result = false;
        if (! file_exists(base_path('app/Http/Controllers/Api/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Controller.php'))) {
            $template = self::getStubContents('controller.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Http/Controllers/Api/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Controller.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateRepositorie()
    {
        $this->result = false;
        if (! file_exists(base_path('app/Http/Repositories/Api/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Repository.php'))) {
            $template = self::getStubContents('controller.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Http/Repositories/Api/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Repository.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateRoute()
    {
        $this->result = false;
        $nameSpace = "\nuse App\Http\Controllers\Api\'.$this->module ? $this->module : $this->model.'\{{modelName}}Controller";
        $template = "Route::apiResource('{{modelNameLower}}', {{modelName}}Controller::class);\n";
        $template = "Route::group(['prefix' => '".$this->module ? $this->module : $this->model."'/{{modelName}}, 'namespace' => 'Api\'".$this->module ? $this->module : $this->model."'], function(){";
        $template += "   Route::get('list', '{{modelName}}Controller@index');";
        $template += "   Route::post('create', '{{modelName}}Controller@create');";
        $template += "   Route::post('show', '{{modelName}}Controller@show');";
        $template += "   Route::post('update', '{{modelName}}Controller@update');";
        $template += "   Route::post('update-status', '{{modelName}}Controller@update_status');";
        $template += "   Route::post('delete', '{{modelName}}Controller@remove');";
        $template += "});";
        $nameSpace = str_replace('{{modelName}}', $this->model, $nameSpace);
        $route = str_replace('{{modelNameLower}}', Str::camel(Str::plural($this->model)), $template);
        $route = str_replace('{{modelName}}', $this->model, $route);
        if (! strpos(file_get_contents(base_path('routes/api.php')), $route)) {
            file_put_contents(base_path('routes/api.php'), $route, FILE_APPEND);
            if (app()->version() >= 8) {
                if (! strpos(file_get_contents(base_path('routes/api.php')), $nameSpace)) {
                    $lines = file(base_path('routes/api.php'));
                    $lines[0] = $lines[0]."\n".$nameSpace;
                    file_put_contents(base_path('routes/api.php'), $lines);
                }
            }
            $this->result = true;
        }

        return $this->result;
    }

    private function getStubContents($stubName)
    {
        return file_get_contents(self::STUB_DIR.$stubName);
    }
}
