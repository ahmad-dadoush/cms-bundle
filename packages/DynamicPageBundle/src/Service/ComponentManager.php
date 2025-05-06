<?php
namespace Dadoush\DynamicPageBundle\Service;

use Dadoush\DynamicPageBundle\Entity\Component;
use Dadoush\DynamicPageBundle\Repository\ComponentRepository;

/**
 * To be used with hand-write admin (no easyadmin)
 */
class ComponentManager
{
    public function __construct(private ComponentRepository $repo) {}

    /** @return Component[] */
    public function all(): array
    {
        return $this->repo->findAll();
    }

    public function find(int $id): ?Component
    {
        return $this->repo->find($id);
    }

    public function save(Component $c): void
    {
        $this->repo->getEntityManager()->persist($c);
        $this->repo->getEntityManager()->flush();
    }

    public function delete(Component $c): void
    {
        $em = $this->repo->getEntityManager();
        $em->remove($c);
        $em->flush();
    }
}