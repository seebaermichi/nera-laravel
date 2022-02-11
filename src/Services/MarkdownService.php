<?php

namespace Nera\Nera\Services;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

class MarkdownService
{
    public function __construct(private CommonMarkConverter $commonMarkConverter)
    {

    }

    public function getPageData($file)
    {
        $parser = new FrontMatterParser(new SymfonyYamlFrontMatterParser());
        $data = $parser->parse($file->getContents());

        return [
            ...($data->getFrontMatter() ?? []),
            'content' => $this->commonMarkConverter
                ->convert($data->getContent())
                ->getContent()
        ];
    }

    public function renderView($data)
    {
        return view($data['layout'])->with($data);
    }
}
