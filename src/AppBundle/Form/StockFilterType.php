<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\ArticuloRepository;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class StockFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', Filters\TextFilterType::class, array(
                'label' => 'Código 3B'
            ));
            // ->add('codArticulo', Filters\EntityFilterType::class, array(
            //     'class' => 'AppBundle\Entity\Articulo',
            //     'choice_label' => 'descripcion',
            //     'label' => 'Código 3B',
            //     'query_builder' => function (\AppBundle\Repository\ArticuloRepository $er) {
            //         return $er->createQueryBuilder('c')
            //             ->orderBy('c.descripcion', 'ASC');
            //         }
            // ));
        $builder->setMethod("GET");
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }


}
