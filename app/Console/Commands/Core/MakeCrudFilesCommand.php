<?php

namespace App\Console\Commands\Core;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Console\Generators\StubGenerator;

class MakeCrudFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {dir} {group} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD files for a given model name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dir = Str::studly($this->argument('dir'));
        $group = Str::studly($this->argument('group'));
        $name = Str::studly($this->argument('name'));
        $plural = Str::pluralStudly($name);

        $this->info("Generating CRUD for {$name}...");

        // Model
        $this->makeModel($group, $name);

        // Migration
        $table = Str::snake($plural);
        $this->makeMigration($table);

        // Seeder
        $this->makeSeeder($name);

        // Controller
        $this->makeController($dir, $group, $name);

        // // Request
        $columns = [
            'status' => 'boolean',
        ];
        $this->makeRequest($group, $name, 'store', $columns);
        $this->makeRequest($group, $name, 'update', $columns);

        // Resource
        $this->makeResource($group, $name);

        // Actions
        $actionTypes = ['list', 'create', 'store', 'show', 'edit', 'update', 'delete', 'restore', 'forceDelete', 'changeStatus'];
        foreach ($actionTypes as $actionType) {
            $this->makeAction($group, $name, $actionType);
        }

        // Service
        $this->makeService($group, $name);

        // Views
        $this->makeViews($group, $name);

        $this->info("CRUD files for {$name} generated successfully.");
        return 0;
    }

    /**
     * Create Model
     */

    protected function makeModel(string $group, string $name)
    {
        $folderPath = app_path("Models/{$group}");

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $path = "{$folderPath}/{$name}.php";

        $stub = base_path("zdx_stubs/model.stub");

        $content = StubGenerator::render($stub, [
            'namespace' => "App\Models\\{$group}",
            'class' => $name,
            'fillable' => "['name', 'email', 'status']",
            'casts' => "['status' => 'boolean']",
        ]);

        file_put_contents($path, $content);
    }

    /**
     * Create Migration
     */

    protected function makeMigration(string $table): void
    {
        $folderPath = database_path('migrations');
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $timestamp = date('Y_m_d_His');
        $fileName = "{$timestamp}_create_{$table}_table.php";
        $path = "{$folderPath}/{$fileName}";

        $stubPath = base_path("zdx_stubs/migration.stub");
        if (!file_exists($stubPath)) {
            throw new Exception("Migration stub not found: {$stubPath}");
        }

        $content = StubGenerator::render($stubPath, [
            'table' => $table,
        ]);

        file_put_contents($path, $content);
    }

    /**
     * Create Seeder
     */

    protected function makeSeeder(string $name)
    {
        $this->callSilent('make:seeder', [
            'name' => "{$name}Seeder",
        ]);
    }

    /**
     * Create Controller
     */
    protected function makeController(string $dir, string $group, string $name)
    {
        $folderPath = app_path("Http/Controllers/{$dir}/{$group}");
        if (!is_dir($folderPath))
            mkdir($folderPath, 0755, true);

        $path = "{$folderPath}/{$name}Controller.php";
        $stub = base_path("zdx_stubs/controller.stub");

        $content = StubGenerator::render($stub, [
            'namespace' => "App\Http\Controllers\\{$dir}\\{$group}",
            'modelNamespace' => "App\Models\\{$group}",
            'model' => $name,
            'modelVar' => lcfirst($name),
            'storeRequest' => "Store{$name}Request",
            'updateRequest' => "Update{$name}Request",
            'requestNamespace' => "App\Http\Requests\\{$group}",
            'resource' => "{$name}Resource",
            'resourceNamespace' => "App\Http\Resources\\{$group}",
            'actionsNamespace' => "App\Actions\\{$group}",
            'class' => "{$name}Controller",
            'inertiaListingPage' => "{$dir}/{$group}/" . "{$name}" . Str::studly('List'),
            'inertiaCreatePage' => "{$dir}/{$group}/" . "{$name}" . Str::studly('create'),
            'inertiaEditPage' => "{$dir}/{$group}/" . "{$name}" . Str::studly('edit'),
            'inertiaDetailsPage' => "{$dir}/{$group}/" . "{$name}" . Str::studly('details'),
        ]);

        file_put_contents($path, $content);
    }

    /**
     * Create Request
     */
    protected function makeRequest(string $group, string $name, string $type, array $columns)
    {
        $folderPath = app_path("Http/Requests/{$group}");
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $stubPath = base_path("zdx_stubs/request/request.{$type}.stub");

        if (!file_exists($stubPath)) {
            throw new Exception("Request stub not found: {$stubPath}");
        }

        // Generate rules
        $rules = '';
        foreach ($columns as $column => $rule) {
            $rules .= "            '{$column}' => '{$rule}',\n";
        }

        $content = StubGenerator::render($stubPath, [
            'namespace' => "App\Http\Requests\\{$group}",
            'model' => $name,
            'rules' => rtrim($rules),
        ]);

        $fileName = ucfirst($type) . "{$name}Request.php";
        file_put_contents("{$folderPath}/{$fileName}", $content);
    }

    /**
     * Create Resource
     */
    protected function makeResource(string $group, string $name)
    {
        $folderPath = app_path("Http/Resources/{$group}");
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $stubPath = base_path("zdx_stubs/resource.stub"); // the FILE path
        if (!file_exists($stubPath)) {
            throw new Exception("Resource stub not found: {$stubPath}");
        }

        $content = StubGenerator::render($stubPath, [
            'namespace' => "App\Http\Resources\\{$group}",
            'class' => "{$name}Resource",
        ]);

        $fileName = "{$name}Resource.php";
        file_put_contents("{$folderPath}/{$fileName}", $content);
    }

    /**
     * Create Action
     */
    protected function makeAction(string $group, string $name, string $actionType)
    {
        $folderPath = app_path("Actions/{$group}");
        if (!is_dir($folderPath))
            mkdir($folderPath, 0755, true);

        $stubPath = base_path("zdx_stubs/actions/action.{$actionType}.stub");
        $methodContent = file_get_contents($stubPath);

        $content = StubGenerator::render($stubPath, [
            'namespace' => "App\Actions\\{$group}",
            'modelNamespace' => "App\Models\\{$group}",
            'serviceNamespace' => "App\Services\\{$group}",
            'model' => $name,
            'service' => "{$name}Service",
            'class' => ucfirst($actionType) . "{$name}Action",
            'modelVar' => lcfirst($name),
            'methods' => $methodContent,
        ]);

        $fileName = ucfirst($actionType) . "{$name}Action.php";
        file_put_contents("{$folderPath}/{$fileName}", $content);
    }

    /*  * Create Service
     */
    protected function makeService(string $group, string $name)
    {
        $folderPath = app_path("Services/{$group}");
        if (!is_dir($folderPath))
            mkdir($folderPath, 0755, true);

        $stubPath = base_path("zdx_stubs/service.stub");

        $content = StubGenerator::render($stubPath, [
            'namespace' => "App\Services\\{$group}",
            'modelNamespace' => "App\Models\\{$group}",
            'model' => $name,
            'modelVariable' => lcfirst($name),
            'class' => "{$name}Service",
        ]);

        $fileName = "{$name}Service.php";
        file_put_contents("{$folderPath}/{$fileName}", $content);
    }

    /* 
     * Create Views
     */

    protected function makeViews(string $group, string $name)
    {
        $folderPath = resource_path("js/pages/{$group}");
        if (!is_dir($folderPath))
            mkdir($folderPath, 0755, true);

        $viewFiles = ['create', 'edit', 'list', 'details'];

        foreach ($viewFiles as $viewFile) {
            $stubPath = base_path("zdx_stubs/views/vue/view.{$viewFile}.stub");
            if ($viewFile === 'create') {
                $content = StubGenerator::render($stubPath, [
                    'model' => $name,
                    'modelVar' => lcfirst($name),
                    'modelsVar' => lcfirst(Str::pluralStudly($name)),
                ]);
            } elseif ($viewFile === 'edit') {
                $content = StubGenerator::render($stubPath, [
                    'model' => $name,
                    'modelVar' => lcfirst($name),
                ]);
            } elseif ($viewFile === 'list') {
                $content = StubGenerator::render($stubPath, [
                    'model' => $name,
                    'modelsVar' => lcfirst(Str::pluralStudly($name)),
                ]);
            } elseif ($viewFile === 'details') {
                $content = StubGenerator::render($stubPath, [
                    'model' => $name,
                    'modelVar' => lcfirst($name),
                ]);
            } else {
                continue;
            }
            $fileName = Str::studly($group) . Str::studly($viewFile) . ".vue";
            file_put_contents("{$folderPath}/{$fileName}", $content);
        }
    }


}