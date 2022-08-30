<?php

namespace Deka\LaravelPackageTools\Commands;

use Illuminate\Console\Command;

class SwitchRepositoryCommand extends Command
{
    public $signature = 'deka:repo-switch {mode}';

    public $description = 'Add Repository';

    public function handle(): int
    {
        $mode = $this->argument('mode');

        $prodUrl = config('deka.package.repo.production');
        $devUrl = config('deka.package.repo.development');

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $repositories = collect($composer['repositories'] ?? []);

        $repositories = $repositories->reject(function($value, $key) use($prodUrl, $devUrl){
            return $value['type'] === 'composer' && ($value['url'] === $prodUrl || $value['url'] === $devUrl);
        });

        if(in_array($mode, ['dev', 'development', 'local'])){
            $repositories->add([
                'type' => 'composer',
                'url' => $devUrl,
            ]);
            $url = $devUrl;
        }else{
            $repositories->add([
                'type' => 'composer',
                'url' => $prodUrl,
            ]);
            $url = $prodUrl;
        }

        $composer['repositories'] = $repositories->toArray();

        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $this->comment("Repository Switched to $url");

        return self::SUCCESS;
    }
}
