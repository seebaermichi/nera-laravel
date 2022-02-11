<?php

namespace Nera\Nera\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nera\Nera\Services\MarkdownService;

class NeraCommand extends Command
{
    public $signature = 'nera';

    public $description = 'Compiles Markdown files to Html files';

    public function handle(MarkdownService $markdownService): int
    {
        $inputPath = resource_path(config('nera.input_path'));
        $outputPath = storage_path(config('nera.output_path'));

        if (! File::isDirectory($inputPath)) {
            $this->error('The configured input path "' . $inputPath . '" doesn not exist.');

            return self::FAILURE;
        }

        $markdownFiles = File::allFiles($inputPath);
        $this->output->info(sprintf('Processing %d Files', count($markdownFiles)));
        $progressBar = $this->output->createProgressBar(count($markdownFiles));
        $progressBar->start();

        foreach ($markdownFiles as $markdownFile) {
            $pageData = $markdownService->getPageData($markdownFile);
            $path = $outputPath . ($markdownFile->getRelativePath() !== ''
                ? '/' . $markdownFile->getRelativePath()
                : '');
            $file = $path . '/' . str_replace('md', 'html', $markdownFile->getFilename());

            if (! File::isDirectory($path)) {
                File::makeDirectory($path);
            }

            $html = isset($pageData['layout']) ? $markdownService->renderView($pageData) : $pageData['content'];

            File::put($file, $html);

            $this->output->info('Writing ' . $file);
            sleep(1);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->output->info('Done');
        return self::SUCCESS;
    }
}
