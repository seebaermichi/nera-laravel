<?php

namespace Nera\Nera\Models;

use Illuminate\Support\Facades\Config;

class Addon
{
    public function __construct(private string $path)
    {
        $this->install();
    }

    private function install()
    {
        $addons = config('nera.addons');
        $addons[] = $this->path;
        sort($addons);

        config()->set('nera.addons', $addons);
    }
}
