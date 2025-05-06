<?php
namespace Dadoush\DynamicPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dadoush\DynamicPageBundle\Repository\ComponentRepository;

#[ORM\Entity(repositoryClass: ComponentRepository::class)]
#[ORM\Table(name: 'component')]
class Component
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $template = null;

    #[ORM\Column(type: 'json')]
    private array $fields = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }
    public function setTemplate(?string $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
    public function setFields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }
}
