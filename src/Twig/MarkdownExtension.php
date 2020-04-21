<?php

namespace App\Twig;

use App\Twig\MarkdownRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MarkdownExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('markdown', [ MarkdownRuntime::class, 'convert' ], ['is_safe' => ['all']]),
        ];
    }
}
