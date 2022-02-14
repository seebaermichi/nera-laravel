<?php

use Illuminate\Console\Command;
use Nera\Nera\Commands\InstallAddonCommand;
use function Pest\Laravel\artisan;

it('fails without parameter addon', function () {
    artisan(InstallAddonCommand::class, [
        'addon' => ''
    ])
        ->assertExitCode(Command::FAILURE);
});

it('adds addon path to config', function () {
    artisan(InstallAddonCommand::class, [
        'addon' => 'nera/simple-navigation'
    ])
        ->assertExitCode(Command::SUCCESS);

    $this->assertContains('nera/simple-navigation', config('nera.addons'));
});
