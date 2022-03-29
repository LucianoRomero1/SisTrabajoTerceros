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
            ->add('codDesvio', Filters\TextFilterType::class, array(
                'label' => 'Código desvío'
            ))
            ->add('nroPartida', Filters\TextFilterType::class, array(
                'label' => 'N° partida'
            ))
            ->add('caracteristica', Filters\ChoiceFilterType::class, array(
                'label' => 'Para',
                'choices'  => [
                    'A Nitrurar'                    => 1,
                    'A PVD'                         => 2,
                    'A Mecanizado'                  => 3,
                    'Forja - Tratamiento térmico'   => 4,
                    'Huecas a perforar'             => 5,
                ],
            ))
            ->add('aRetrabajar', Filters\ChoiceFilterType::class, array(
                'choices'  => [
                    'A retrabajar'    => 1,
                ],
            ))
            ->add('codDeposito', Filters\EntityFilterType::class, array(
                'class' => 'AppBundle\Entity\Deposito',
                'choice_label' => 'id',
                'label' => 'Código depósito',
                'query_builder' => function (\AppBundle\Repository\DepositoRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id = 100')
                        ->orWhere('c.id = 102')
                        ->orWhere('c.id = 103')
                        ->orWhere('c.id = 201')
                        ->orWhere('c.id = 202')
                        ->orWhere('c.id = 301')
                        ->orderBy('c.id', 'ASC');
                    }
            ))
            // ->add('codDeposito', Filters\TextFilterType::class, array(
            //     'label' => 'Código depósito'
            // ))
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
