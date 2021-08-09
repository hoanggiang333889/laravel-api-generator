<?php

namespace Giangmv\LaravelApiGenerator\Commands;

use Giangmv\LaravelApiGenerator\LaravelApiGenerator;
use Illuminate\Console\Command;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate {--model=} {--module=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'REST Api Generator With API Resources';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (empty($this->option('model'))) {
            $this->error('Model Name Argument not found!');

            return false;
        }

        if (! file_exists(base_path(config('laravel-api-generator.model_directory_path').'/'.$this->option('model').'.php'))) {
            $this->error('Model does not exist!');

            return false;
        }

        $api = new LaravelApiGenerator($this->option('model'), $this->option('module'));
        $controller = $api->generateController();
        if ($controller) {
            $this->info('Controller Generated SuccessFully!');
        } else {
            $this->error('Controller Already Exists!');
        }

        $Repository = $api->generateRepositorie();
        if ($Repository) {
            $this->info('Repository Generated SuccessFully!');
        } else {
            $this->error('Repository Already Exists!');
        }

        $route = $api->generateRoute();
        if ($route) {
            $this->info('Route Generated SuccessFully!');
        } else {
            $this->error('Route Already Exists!');
        }

        $this->info('Api Created SuccessFully!');

        return true;
    }
}
