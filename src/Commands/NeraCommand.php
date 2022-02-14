<?php

namespace Nera\Nera\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nera\Nera\Models\Page;
use Nera\Nera\Services\PageService;

class NeraCommand extends Command
{
    public $signature = 'nera';

    public $description = 'Compiles Markdown files to Html files';

    public function handle(PageService $pageService): int
    {
        $inputPath = resource_path(config('nera.input_path'));
        $outputPath = storage_path(config('nera.output_path'));

        if (! File::isDirectory($inputPath)) {
            $this->error('The configured input path "' . $inputPath . '" doesn not exist.');

            return self::FAILURE;
        }

        if (File::isDirectory($outputPath)) {
            File::deleteDirectory($outputPath);
        }

        $markdownFiles = File::allFiles($inputPath);
        $this->output->info(sprintf('Processing %d Files', count($markdownFiles)));
        $progressBar = $this->output->createProgressBar(count($markdownFiles));
        $progressBar->start();

        foreach ($markdownFiles as $markdownFile) {
            $page = new Page($markdownFile);

            if (! File::isDirectory($page->getDataProperty('path'))) {
                File::makeDirectory($page->getDataProperty('path'));
            }

            $html = $page->hasDataProperty('layout') ? $pageService->renderView($page) : $page->content;

            File::put($page->getDataProperty('pathname'), $html);

            $this->output->info('Writing ' . $page->getDataProperty('pathname'));
            sleep(1);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->output->info('Done');

        return self::SUCCESS;
    }
}
