<?php

namespace Deka\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LinkPackageCommand extends Command
{
    public $signature = 'deka:package-link {vendors?*}';

    public $description = 'Symlink package';

    public function handle(): int
    {
        $vendors = array_unique(array_merge(config('deka.package.vendors'), $this->argument('vendors')));
        $regex = '/^('.implode('|', $vendors).')\/(.*)/';

        $packages = [];

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $require = collect($composer['require'] ?? []);

        foreach ($require as $package => $version) {
            if (preg_match($regex, strval($package))) {
                $packages[] = $package;
            }
        }

        $repositories = collect($composer['repositories'] ?? []);

        foreach ($packages as $name) {
            $repositories = $repositories->reject(function ($value, $key) use ($name) {
                return in_array($value['type'], ['vcs', 'path']) && $value['name'] === $name;
            });

            $url = $this->packagePath($name);

            $repositories->add([
                'name' => $name,
                'type' => 'path',
                'url' => $url,
            ]);

            $vendorPath = base_path("vendor/$name");

            @unlink($vendorPath); // remove vendor
            @symlink(strval($url), strval($vendorPath)); // symlink

            $this->comment("Package {$name} symlinked composer.json");
        }

        $composer['repositories'] = $repositories->values()->toArray();
        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }

    public function packagePath($name)
    {
        $developmentDir = config('deka.package.directory');
        throw_if(! file_exists($developmentDir), 'Development Package Directory Not Exists');

        $guessPackageDirs = [
            "$developmentDir/".Str::of($name)->basename(),
            "$developmentDir/$name",
        ];

        $packageDir = null;

        foreach ($guessPackageDirs as $path) {
            if (file_exists($path)) {
                $packageDir = $path;
                break;
            }
        }

        throw_if(! $packageDir, "Package Directory Not Exists $name");

        return $packageDir;
    }
}
