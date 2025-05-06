<?php

namespace Dadoush\DynamicPageBundle\Controller\Admin;

use Dadoush\DynamicPageBundle\Entity\Component;
use Dadoush\DynamicPageBundle\Form\ComponentType;
use Dadoush\DynamicPageBundle\Service\ComponentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/component', name:'dynamic_page_admin_')]
class ComponentAdminController extends AbstractController
{
    public function __construct(private ComponentManager $mgr) {}

    #[Route('/', name:'index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('@DynamicPage/admin/index.html.twig', [
            'components'=>$this->mgr->all(),
        ]);
    }

    #[Route('/new', name:'new', methods:['GET','POST'])]
    public function new(Request $r): Response
    {
        $c = new Component();
        $f = $this->createForm(ComponentType::class, $c);
        $f->handleRequest($r);
        if ($f->isSubmitted() && $f->isValid()) {
            $this->mgr->save($c);
            return $this->redirectToRoute('dynamic_page_admin_index');
        }
        return $this->render('@DynamicPage/admin/form.html.twig', ['form'=>$f->createView()]);
    }

    #[Route('/{id}/edit', name:'edit', methods:['GET','POST'])]
    public function edit(Request $r, Component $c): Response
    {
        $f = $this->createForm(ComponentType::class, $c);
        $f->handleRequest($r);
        if ($f->isSubmitted() && $f->isValid()) {
            $this->mgr->save($c);
            return $this->redirectToRoute('dynamic_page_admin_index');
        }
        return $this->render('@DynamicPage/admin/form.html.twig', [
            'form'=>$f->createView(),'component'=>$c
        ]);
    }

    #[Route('/{id}/delete', name:'delete', methods:['POST'])]
    public function delete(Request $r, Component $c): Response
    {
        if ($this->isCsrfTokenValid('delete'.$c->getId(), $r->request->get('_token'))) {
            $this->mgr->delete($c);
        }
        return $this->redirectToRoute('dynamic_page_admin_index');
    }
}