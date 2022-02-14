<?php

namespace Nera\Nera\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nera\Nera\Models\Addon;
use Nera\Nera\Models\Page;
use Nera\Nera\Services\PageService;

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
