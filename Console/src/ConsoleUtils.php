<?php
declare(strict_types=1);

namespace TallAndSassy\Console;

final class ConsoleUtils {
    /**
     * Copied from vendor/laravel/jetstream/src/Console/InstallCommand.php
     * Update the "package.json" file.
     * https://laracasts.com/discuss/channels/elixir/devdependencies-vs-dependencies
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    public static function UpdateNodePackages(callable $callback, string $enum_dev_prod)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = ($enum_dev_prod == 'prod') ? 'dependencies' : 'devDependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}