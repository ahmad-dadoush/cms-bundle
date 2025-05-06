<?php

namespace Dadoush\DynamicPageBundle\Controller\EasyAdmin;

use Dadoush\DynamicPageBundle\Entity\Component;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextField, ArrayField};
use EasyCorp\Bundle\EasyAdminBundle\Config\{Crud, Filters};

class ComponentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Component::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Component')
            ->setEntityLabelInPlural('Components')
            ->setSearchFields(['id', 'name'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield TextField::new('template');
        yield ArrayField::new('fields')
            ->setFormTypeOptions(['attr' => ['rows' => 10]]);
    }
}
