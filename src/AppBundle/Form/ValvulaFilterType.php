<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class ValvulaFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoMovimiento', Filters\ChoiceFilterType::class, array(
                'label' => 'Tipo de movimiento',
                'choices'  => [
                    'Envío a 3°'        => 1,
                    'Reingreso de 3°'   => 2,
                    'Recepción de 3°'   => 3,
                    'Devolución de  3°' => 4,
                ],
            ))
            ->add('codDesvio', Filters\TextFilterType::class, array(
                'label' => 'Código desvío'
            ))
            ->add('nroPartida', Filters\TextFilterType::class, array(
                'label' => 'N° partida'
            ))
            ->add('caracteristica', Filters\ChoiceFilterType::class, array(
                'label' => 'Para',
                'choices'  => [
                    'A Nitrurar'    => 1,
                    'A PVD'         => 2,
                    'A Mecanizado'  => 3,
                ],
            ))
            ->add('aRetrabajar', Filters\ChoiceFilterType::class, array(
                'choices'  => [
                    'A retrabajar'    => 1,
                ],
            ))
            ->add('codDeposito', Filters\TextFilterType::class, array(
                'label' => 'Código depósito'
            ))
            ->add('fecha', Filters\DateRangeFilterType::class,  array(
                'label' => 'Fecha',
                'left_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'Desde'
                ),
                'right_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'Hasta'
                )
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
