<?php

namespace Nera\Nera\Models;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use Symfony\Component\Finder\SplFileInfo;

class Page
{
    public string $content;
    public string $title;
    private array $data;

    public function __construct(
        SplFileInfo $fileInfo
    ) {
        $commonMarkConverter = new CommonMarkConverter();
        $parser = new FrontMatterParser(new SymfonyYamlFrontMatterParser());
        $markdown = $parser->parse($fileInfo->getContents());

        $this->data = $markdown->getFrontMatter() ?? [];
        $this->setPath($fileInfo);
        $this->setPathname($fileInfo);
        $this->setUrl();

        $this->title = $this->getDataProperty('title') ?? '';
        $this->setMeta();

        $this->content = $commonMarkConverter
            ->convert($markdown->getContent())
            ->getContent();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function hasDataProperty(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function getDataProperty(string $key): mixed
    {
        if (! array_key_exists($key, $this->data)) {
            return null;
        }

        return $this->data[$key];
    }

    public function setDataProperty(string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    private function setMeta(): void
    {
        foreach (config('nera.meta_tags') as $metaTag) {
            $this->$metaTag = $this->getDataProperty($metaTag) ?? config('nera.' . $metaTag) ?? '';
        }
    }

    public function getMeta(): array
    {
        $meta = [];
        foreach (config('nera.meta_tags') as $metaTag) {
            if ($this->$metaTag !== '') {
                $meta[$metaTag] = $this->$metaTag;
            }
        }

        return $meta;
    }

    private function setPath(SplFileInfo $fileInfo): void
    {
        $this->data['path'] = storage_path(config('nera.output_path')) . ($fileInfo->getRelativePath() !== ''
                ? '/' . $fileInfo->getRelativePath()
                : '');
    }

    private function setPathname(SplFileInfo $fileInfo): void
    {
        $this->data['pathname'] = sprintf(
            '%s/%s',
            $this->getDataProperty('path'),
            str_replace('md', 'html', $fileInfo->getFilename())
        );
    }

    private function setUrl()
    {
        $this->data['url'] = explode('public', $this->getDataProperty('pathname'))[1];
    }
}
