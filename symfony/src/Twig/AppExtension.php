<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{

    public $locale;


    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    public function getGlobals()
    {
        return [
            'locale' =>  $this->locale
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter($number) {
        return number_format($number, 0, '', ',').'€';
    }

}