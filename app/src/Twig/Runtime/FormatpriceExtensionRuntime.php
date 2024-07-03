<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class FormatpriceExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function formatPrice(float $number,
                                int $decimal = 0,
                                string $decPoint = '.',
                                string $thousandSep = ",",
                                string $currency = "$"
    ) : string
    {
        $price = number_format($number, $decimal,$decPoint, $thousandSep );
        $price .= " ".$currency;
        return $price;
    }
}
