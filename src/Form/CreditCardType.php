<?php

namespace App\Form;

use App\Entity\CreditCard;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number',TextType::class,
            ['attr' => [
                'minlength' => 16,'maxlength' => 16,
            ]])
            ->add('expirationDate',  DateType::class, [
                'widget' => 'choice',
                'format' => 'dd/MM/yy',
                'years' => range(date('Y') , date('Y') + 10),
            ])
            ->add('cvv',TextType::class,
            ['attr' => [
                'minlength' => 3,'maxlength' => 3,
            ]])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreditCard::class,
        ]);
    }
}