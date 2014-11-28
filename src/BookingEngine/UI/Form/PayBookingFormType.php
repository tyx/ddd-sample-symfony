<?php

namespace Afsy\BookingEngine\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PayBookingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creditCardHolder', 'text')
            ->add('creditCardNumber', 'text')
            ->add('creditCardCvc', 'text')
            ->add('creditCardExpirationDate', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Afsy\BookingEngine\App\PayBookingCommand',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'pay_booking';
    }
}
