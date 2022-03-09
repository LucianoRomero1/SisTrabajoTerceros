<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class PartidasMovFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class, array(
                'label'     => 'N° partida'
            ))
            ->add('codDesvio', Filters\TextFilterType::class, array(
                'label' => 'Código desvío'
            ))
            ->add('codTipoMov', Filters\NumberFilterType::class, array(
                'label'     => 'Código tipo movimiento'
            ))
            ->add('fecha')
            ->add('nroMov', Filters\NumberFilterType::class, array(
                'label'     => 'N° movimiento'
            ))
            ->add('codArticulo', Filters\NumberFilterType::class, array(
                'label'     => 'Código artículo'
            ))
            ->add('cantidad', Filters\NumberFilterType::class, array(
                'label'     => 'cantidad'
            ))
            ->add('valvDesvio', Filters\TextFilterType::class, array(
                'label' => 'Válvula desvío'
            ))
            ->add('depoOrigen', Filters\NumberFilterType::class, array(
                'label'     => 'Depósito origen'
            ))
            ->add('indProcPartida', Filters\NumberFilterType::class, array(
                'label'     => '...'
            ))
            ->add('codCpte', Filters\NumberFilterType::class, array(
                'label'     => 'Código cpte'
            ));
        $builder->setMethod("GET");
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') 
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
