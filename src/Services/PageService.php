<?php

namespace Nera\Nera\Services;

use Illuminate\View\View;
use Nera\Nera\Models\Page;

class PageService
{
    public function renderView(Page $page): View
    {
        return view($page->getDataProperty('layout'), compact('page'));
    }
}
