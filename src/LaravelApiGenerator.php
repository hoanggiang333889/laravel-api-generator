<?php

namespace Giangmv\LaravelApiGenerator;

use Illuminate\Support\Str;

class LaravelApiGenerator
{
    const STUB_DIR = __DIR__.'/resources/stubs/';
    protected $model;
    protected $module;
    protected $table;
    protected $result = false;

    public function __construct(string $model, string $module, string $table)
    {
        $this->model = $model;
        $this->module = $module;
        $this->table = $table;
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
        if (! file_exists(base_path('app/Repositories'))) {
            mkdir(base_path('app/Repositories'));
        }
        if (! file_exists(base_path('app/Services'))) {
            mkdir(base_path('app/Services'));
        }
        if (! file_exists(base_path('app/Http/Requests'))) {
            mkdir(base_path('app/Http/Requests'));
        }
        if (! file_exists(base_path('app/Http/Resources'))) {
            mkdir(base_path('app/Http/Resources'));
        }
    }

    public function generateController()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Http/Controllers/Api/".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Http/Controllers/Api/".($this->module ? $this->module : null)));
        }
        if (!file_exists(base_path('app/Http/Controllers/Api/'.($this->module ? $this->module : $this->model).'/'.$this->model.'Controller.php'))) {
            $template = self::getStubContents('controller.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Http/Controllers/Api/'.($this->module ? $this->module : $this->model).'/'.$this->model.'Controller.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateRepositorie()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Repositories/".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Repositories/".($this->module ? $this->module : null)));
        }
        if (! file_exists(base_path('app/Repositories/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Repository.php'))) {
            $template = self::getStubContents('repository.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Repositories/'.($this->module ? $this->module : $this->model).'/'.$this->model.'Repository.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateService()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Services/".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Services/".($this->module ? $this->module : null)));
        }
        if (! file_exists(base_path('app/Services/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Service.php'))) {
            $template = self::getStubContents('service.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Services/'.($this->module ? $this->module : $this->model).'/'.$this->model.'Service.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateResources()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Http/Resources/".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Resources/".($this->module ? $this->module : null)));
        }
        if (! file_exists(base_path('app/Http/Resources/'.$this->module ? $this->module : $this->model.'/'.$this->model.'Resource.php'))) {
            $template = self::getStubContents('resource.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            $this->table =  $this->model->plural()->snake();
            $fields = [];
            if (Schema::hasTable($this->table)) {
                $this->info('Table "' . $this->table . '" already existed');
                $fields = Schema::getColumnListing($this->table);
                if (!count($fields)) {
                    $this->error('No fields found');
    
                    return;
                }
            }
    
            $template = str_replace('{{fields}}', $fields, $template);
            file_put_contents(base_path('app/Http/Resources/'.($this->module ? $this->module : $this->model).'/'.$this->model.'Resource.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateCreateRequest()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Http/Requests/Create".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Http/Requests/Create".($this->module ? $this->module : null)));
        }
        if (! file_exists(base_path('app/Http/Requests/Create'.$this->module ? $this->module : $this->model.'/'.$this->model.'Request.php'))) {
            $template = self::getStubContents('create_request.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            $this->table =  $this->model->plural()->snake();
            $fields = [];
            if (Schema::hasTable($this->table)) {
                $this->info('Table "' . $this->table . '" already existed');
                $fields = Schema::getColumnListing($this->table);
                if (!count($fields)) {
                    $this->error('No fields found');
    
                    return;
                }
            }
    
            $template = str_replace('{{fields}}', $fields, $template);
            
            file_put_contents(base_path('app/Http/Requests/Create'.($this->module ? $this->module : $this->model).'/'.$this->model.'Request.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateUpdateRequest()
    {
        $this->result = false;
        if (!file_exists(base_path("app/Http/Requests/Update".($this->module ? $this->module : null)))) {
            mkdir(base_path("app/Http/Requests/Update".($this->module ? $this->module : null)));
        }
        if (! file_exists(base_path('app/Http/Requests/Create'.$this->module ? $this->module : $this->model.'/'.$this->model.'Request.php'))) {
            $template = self::getStubContents('update_request.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            $this->table =  $this->model->plural()->snake();
            $fields = [];
            if (Schema::hasTable($this->table)) {
                $this->info('Table "' . $this->table . '" already existed');
                $fields = Schema::getColumnListing($this->table);
                if (!count($fields)) {
                    $this->error('No fields found');
    
                    return;
                }
            }
    
            $template = str_replace('{{fields}}', $fields, $template);
            
            file_put_contents(base_path('app/Http/Requests/Update'.($this->module ? $this->module : $this->model).'/'.$this->model.'Request.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateRoute()
    {
        $this->result = false;
        $template = "// start new route group ".($this->module ? strtolower($this->module) : strtolower($this->model))."\n";
        $template .= "Route::group(['prefix' => '".($this->module ? strtolower($this->module) : strtolower($this->model))."', 'namespace' => 'Api\\".($this->module ? $this->module : $this->model)."'], function(){\n";
        $template .= "   Route::get('list', '{{modelName}}Controller@index');\n";
        $template .= "   Route::post('create', '{{modelName}}Controller@create');\n";
        $template .= "   Route::post('show', '{{modelName}}Controller@show');\n";
        $template .= "   Route::post('update', '{{modelName}}Controller@update');\n";
        $template .= "   Route::post('update-status', '{{modelName}}Controller@update_status');\n";
        $template .= "   Route::post('delete', '{{modelName}}Controller@remove');\n";
        $template .= "});\n";
        $template .= "// end new route group ".($this->module ? strtolower($this->module) : strtolower($this->model))."\n";
        $route = str_replace('{{modelNameLower}}', Str::camel(Str::plural($this->model)), $template);
        $route = str_replace('{{modelName}}', $this->model, $route);
        if (! strpos(file_get_contents(base_path('routes/api.php')), $route)) {
            file_put_contents(base_path('routes/api.php'), $route, FILE_APPEND);
            if (app()->version() >= 8) {
                $lines = file(base_path('routes/api.php'));
                file_put_contents(base_path('routes/api.php'), $lines);
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
