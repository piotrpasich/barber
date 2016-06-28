<?php

namespace BarberBundle\Form;

use BarberBundle\Entity\User;
use BarberBundle\TimePeriod\TimePeriodCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('GET');

        $builder
            ->add('user', EntityType::class, [
                'class' => 'BarberBundle:User',
                'choice_label' => 'username',
                'placeholder' => 'All',
                'required' => false,
            ])
            ->add('service', EntityType::class, [
                'class' => 'BarberBundle:Service',
                'choice_label' => 'name',
                'placeholder' => 'All',
                'required' => false,
            ])
            ->add('timePeriod', ChoiceType::class, [
                'choices' => (new TimePeriodCollection())->toArray(),
                'placeholder' => 'All',
                'required' => false,
            ]);

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    public function getName()
    {
        return '';
    }
}
