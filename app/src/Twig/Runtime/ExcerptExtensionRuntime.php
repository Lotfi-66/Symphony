<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ExcerptExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function excerpt($text, $limit = 40)
    {
        return (strlen($text) <= $limit) ? ($text) : (substr($text, 0, $limit - 3 ) . "...");
    }
}
