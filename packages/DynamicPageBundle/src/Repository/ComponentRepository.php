<?php
namespace Dadoush\DynamicPageBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dadoush\DynamicPageBundle\Entity\Component;

class ComponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Component::class);
    }

    public function findOneByName(string $name): ?Component
    {
        return $this->findOneBy(['name' => $name]);
    }
}