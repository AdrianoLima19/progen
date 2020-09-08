<?php

namespace Progen\Generator;

class Lorem
{
    private $text;
    
    public function __construct($paragraphs = null, $type = null, $style = "plaintext")
    {
        /**
         * (integer) - The number of paragraphs to generate.
         * short, medium, long, verylong - The average length of a paragraph.
         * plaintext - Return plain text, no HTML.
         */
        if (!$paragraphs) {
            $paragraphs = rand(1,3);
        }
        if (!$type) {
            $types = ['short', 'medium', 'long', 'verylong'];
            $type = array_rand($types, 1);
        }

        $getContent = file_get_contents("https://loripsum.net/api/{$paragraphs}/{$type}/{$style}");

        $this->text = $getContent;
    }

    public function getText()
    {
        return $this->text;
    }
}