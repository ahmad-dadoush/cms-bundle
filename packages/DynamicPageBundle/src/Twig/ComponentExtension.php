<?php

namespace Dadoush\DynamicPageBundle\Twig;

use Dadoush\DynamicPageBundle\Service\ComponentRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ComponentExtension extends AbstractExtension
{
    public function __construct(
        private readonly ComponentRenderer $renderer
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'cms_component',
                [$this->renderer, 'render'],
                ['is_safe' => ['html']]
            ),
        ];
    }
}
