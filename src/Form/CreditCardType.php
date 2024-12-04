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
use Symfony\Component\Validator\Constraints as Assert;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number',TextType::class,
            ['attr' => [
                'minlength' => 16,'maxlength' => 16,
                ],
            'constraints' => [
                new Assert\Length([
                    'min' => 16,
                    'max' => 16,
                    'exactMessage' => 'Le CVV doit contenir exactement 3 caractères.',
                ])
            ]])
            ->add('expirationDate',  DateType::class, [
                'widget' => 'choice',
                'format' => 'dd/MM/yy',
                'years' => range(date('Y') , date('Y') + 10),
            ])
            ->add('cvv',TextType::class,
            ['attr' => [
                'minlength' => 3,'maxlength' => 3,
            ],
            'constraints' => [
                new Assert\Length([
                    'min' => 3,
                    'max' => 3,
                    'exactMessage' => 'Le CVV doit contenir exactement 3 caractères.',
                ])
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreditCard::class,
        ]);
    }
}
