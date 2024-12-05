<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street',null,['attr'=>["class"=>"form-control"],'label'=>'addressForm.street'])
            ->add('postalCode',null,['attr' => ['class' => 'form-control'],'label'=>'addressForm.postalCode'])
            ->add('city',null,['attr' => ['class' => 'form-control'],'label'=>'addressForm.city'])
            ->add('country',null,['attr' => ['class' => 'form-control'],'label'=>'addressForm.country'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
