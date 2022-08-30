<?php

namespace Deka\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class AddPackageCommand extends Command
{
    public $signature = 'deka:package-add {name} {directory?} {--F|from=local}';

    public $description = 'Add package';

    public function handle(): int
    {
        $name = $this->argument('name');
        $directory = $this->argument('directory');
        $from = $this->option('from');

        if($from === 'local'){
            $developmentDir = config('deka.package.directory');
            throw_if(!file_exists($developmentDir), "Development Package Directory Not Exists");

            $guessPackageDirs = [
                ...($directory ? [$developmentDir."/".$directory] : []),
                "$developmentDir/" . Str::of($name)->basename(),
                "$developmentDir/$name",
            ];

            $packageDir = null;

            foreach($guessPackageDirs as $path){
                if(file_exists($path)){
                    $packageDir = $path;
                    break;
                }
            }

            throw_if(!$packageDir, "Package Directory Not Exists $name");
            $packageUrl = $packageDir;
        }else{
            $token = config('deka.package.token');
            $packageUrl = "https://$token:x-oauth-basic@github.com/$name.git";
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $repositories = collect($composer['repositories'] ?? []);

        $type = match($from){
            default => 'vcs',
            'local' => 'path',
        };

        if($repositories->where('type', $type)->where('name', $name)->count() === 0){
            $repositories->add([
                'name' => $name,
                'type' => $type,
                'url' => $packageUrl,
            ]);
        }

        $composer['repositories'] = $repositories->toArray();

        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $this->comment("package {$name} add to composer.json");

        return self::SUCCESS;
    }
}
