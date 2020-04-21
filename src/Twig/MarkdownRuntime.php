<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use Michelf\MarkdownExtra;
use Highlight\Highlighter;

class MarkdownRuntime implements RuntimeExtensionInterface
{
    /**
    * @var Highlighter
    */
    private $highlighter;

    public function __construct()
    {
        $this->highlighter = new Highlighter();
    }

    public function convert(string $body): string
    {
        // Remove indentation
        if ($white = substr($body, 0, strspn($body, " \t\r\n\0\x0B"))) {
            $body = preg_replace("{^$white}m", '', $body);
        }

        // Convert markdown to html
        $parser = new MarkdownExtra();

        $parser->code_span_content_func = function($code) {
            $highlighted = $this->highlighter->highlightAuto($code);

            return $highlighted->value;
        };

        $parser->code_block_content_func = function($code, $language) {
            $highlighted = $this->highlighter->highlightAuto($code);

            return $highlighted->value;
        };

        return $parser->transform($body);
    }
}
