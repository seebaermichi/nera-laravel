<?php

namespace Nera\Nera\Commands;

use Illuminate\Console\Command;

class NeraCommand extends Command
{
    public $signature = 'nera';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
