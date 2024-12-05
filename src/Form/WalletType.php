<?php

namespace App\Form;

use App\Entity\Wallet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creditCards',CollectionType::class, [
                'entry_type' => CreditCardType::class,
                'allow_add' => true,
                'label' => false,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ["label"=>false],
                'attr' => [
                    'data-controller' => 'credit-card'
                ]
            ])
            ->add('submit', SubmitType::class,['label'=>'walletForm.submit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
        ]);
    }
}
