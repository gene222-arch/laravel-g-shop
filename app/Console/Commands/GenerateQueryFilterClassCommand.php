<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class GenerateQueryFilterClassCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:query-filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new query filter class';

    protected function getStub()
    {
        return __DIR__ . '/stubs/query.filter.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\QueryFilters';
    }
}
