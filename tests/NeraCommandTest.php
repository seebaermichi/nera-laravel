<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nera\Nera\Commands\NeraCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->inputPath = resource_path(config('nera.input_path'));
    $this->outputPath = storage_path(config('nera.output_path'));
    $this->files = [
        'index.md',
        'services/index.md',
        'services/prices.md',
        'about.md',
    ];
});

afterEach(function () {
    File::deleteDirectory($this->inputPath);
    File::deleteDirectory($this->outputPath);
});

it('fails if configured input_path does not exist', function () {
    File::deleteDirectory($this->inputPath);

    artisan(NeraCommand::class)
        ->assertExitCode(Command::FAILURE);
});

it('creates simple html files form markdown files', function () {
    if (! File::isDirectory($this->inputPath)) {
        File::makeDirectory($this->inputPath, 0777, true);
    }

    foreach ($this->files as $file) {
        $path = $this->inputPath;

        if (str_contains($file, '/')) {
            $subPaths = explode('/', $file);
            $file = array_pop($subPaths);
            $path .= '/'. implode('/', $subPaths);

            if (! File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true);
            }
        }

        File::put($path . '/' . $file, '# ' . ucfirst($file));
    }

    artisan(NeraCommand::class)
        ->assertExitCode(Command::SUCCESS);

    $htmlFiles = File::allFiles($this->outputPath);

    $this->assertCount(4, $htmlFiles);
});

it('reads meta data and uses layout', function () {
    if (! File::isDirectory($this->inputPath)) {
        File::makeDirectory($this->inputPath, 0777, true);
    }

    $viewPath = 'views/pages';
    if (! File::isDirectory(resource_path($viewPath))) {
        File::makeDirectory(resource_path($viewPath), 0777, true);
    }

    File::put(resource_path(
        $viewPath) . '/default.blade.php',
        file_get_contents(__DIR__ . '/Fixtures/pages/default.blade.php')
    );
    File::put($this->inputPath . '/test.md', file_get_contents(__DIR__ . '/Fixtures/test.md'));

    artisan(NeraCommand::class)->assertExitCode(Command::SUCCESS);

    $output = File::files($this->outputPath);
    $content = $output[0]->getContents();

    $this->assertStringContainsString('<title>Home</title>', $content);
    $this->assertStringContainsString(
        '<meta name="description" content="This is Nera, a light weight static site generator">',
        $content
    );
    $this->assertStringContainsString(
        '<meta name="keywords" content="nera, light weight, static site generator">',
        $content
    );
    $this->assertStringContainsString(
        '<meta name="robots" content="index,follow">',
        $content
    );
    $this->assertStringContainsString(
        '<h1>Nera - a lightweight static site generator</h1>',
        $content
    );
});
