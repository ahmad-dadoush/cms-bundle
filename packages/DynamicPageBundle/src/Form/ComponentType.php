<?php

namespace Dadoush\DynamicPageBundle\Form;

use Dadoush\DynamicPageBundle\Entity\Component;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\JsonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Identifier (unique)',
            ])
            ->add('template', TextType::class, [
                'required' => false,
                'label' => 'Twig template (leave blank for default)',
            ])
            ->add('fields', JsonType::class, [
                'label' => 'Fields (JSON)',
                'help'  => 'Enter a JSON object, e.g. {"title":"Hello","count":3}.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Component::class,
        ]);
    }
}