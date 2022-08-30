<?php

namespace Deka\LaravelPackageTools\Commands;

use Illuminate\Console\Command;

class LaravelPackageToolsCommand extends Command
{
    public $signature = 'laravel-package-tools';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
