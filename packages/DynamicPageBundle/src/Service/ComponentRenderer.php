<?php

namespace Dadoush\DynamicPageBundle\Service;

use InvalidArgumentException;
use Twig\Environment;
use Dadoush\DynamicPageBundle\Repository\ComponentRepository;

class ComponentRenderer
{
    public function __construct(
        private readonly string $defaultTemplate,
        private readonly ComponentRepository $repo,
        private readonly Environment $twig        
    ) {}

    public function render(string $name, array $overrides = []): string
    {
        $component = $this->repo->findOneByName($name);
        if (!$component) {
            throw new InvalidArgumentException(sprintf(
                'Component "%s" not found.',
                $name
            ));
        }

        $template = $component->getTemplate() ?: $this->defaultTemplate;
        $data     = array_merge($component->getFields() ?? [], $overrides);

        return $this->twig->render($template, [
            'fields'    => $data,
            'component' => $component,
        ]);
    }
}