<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class ,['label' => 'registerForm.email'])
            ->add('firstName', TextType::class, ['label' => 'registerForm.firstName'])
            ->add('lastName',TextType::class, ['label' => 'registerForm.lastName'])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'registerForm.plainPassword',
                'attr' => ['autocomplete' => 'new-password','class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add("address", AddressType::class,["label"=>false])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'registerForm.agreeTerms',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'attr'=>['class'=>'my-4']
            ])
            ->add("save",SubmitType::class,["label"=>'registerForm.save','attr' => ['class' => 'btn btn-lg btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
