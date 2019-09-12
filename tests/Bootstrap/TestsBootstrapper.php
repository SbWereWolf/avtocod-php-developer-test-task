<?php

namespace Tests\Bootstrap;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;
use Illuminate\Contracts\Console\Kernel;
use AvtoDev\DevTools\Tests\PHPUnit\Traits\CreatesApplicationTrait;
use AvtoDev\DevTools\Tests\Bootstrap\AbstractLaravelTestsBootstrapper;

class TestsBootstrapper extends AbstractLaravelTestsBootstrapper
{
    use CreatesApplicationTrait;

    /**
     * Проверяет необходимость выполнения миграций и выполняет их, если это требуется.
     *
     * @return bool
     */
    protected function bootNeedMigrateIfNeeded(): bool
    {
        global $argv;

        static $skip_arguments = ['--group', '-g', '--help', '--bootstrap'];

        foreach ((array) $argv as $argument) {
            foreach ($skip_arguments as $skip) {
                if (Str::contains(Str::lower(trim($argument)), Str::lower($skip))) {
                    $this->log(sprintf('Skip database refreshing (argument "%s" found)', $argument));

                    return true;
                }
            }
        }

        $this->refreshDatabase();

        return true;
    }

    /**
     * Выполняет мигрирование БД и наполняет её тестовыми данными.
     */
    protected function refreshDatabase(): void
    {
        /** @var Kernel|null $kernel */
        $kernel = $this->app->make(Kernel::class);
        /** @var Repository $config */
        $config = $this->app->make('config');

        if ($config->get('database.default') === 'sqlite') {
            $db_file_path = $config->get('database.connections.sqlite.database');

            if (!$this->files->exists($db_file_path)) {
                $this->files->put($db_file_path, null);
            }
        }

        $this->log('Refresh migrations..');
        $kernel->call('migrate:refresh');

        $this->log('Apply seeds..');
        $kernel->call('db:seed');
    }
}
