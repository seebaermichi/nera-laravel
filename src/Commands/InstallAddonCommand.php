<?php

namespace Nera\Nera\Commands;

use Illuminate\Console\Command;
use Nera\Nera\Models\Addon;

class InstallAddonCommand extends Command
{
    public $signature = 'nera:install-addon {addon}';

    public $description = 'Adds a Nera addon';

    public function handle(): int
    {
        if (! $this->argument('addon')) {
            return self::FAILURE;
        }

        new Addon($this->argument('addon'));

        return self::SUCCESS;
    }
}
