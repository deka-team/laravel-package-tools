<?php

namespace Deka\LaravelPackageTools\Commands;

use Illuminate\Console\Command;

class AddRepositoryCommand extends Command
{
    public $signature = 'deka:repo-add {url} {--F|force}';

    public $description = 'Add Repository';

    public function handle(): int
    {
        $url = $this->argument('url');
        $force = $this->option('force') ;
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $repositories = collect($composer['repositories'] ?? []);

        if($repositories->where('url', $url)->count() === 0){
            $repositories->add([
                'type' => 'composer',
                'url' => $url,
            ]);
        }

        $composer['repositories'] = $repositories->toArray();

        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $this->comment("Repository {$url} add to composer.json");

        return self::SUCCESS;
    }
}
