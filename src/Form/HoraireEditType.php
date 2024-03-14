<?php

namespace App\Form;

use App\Entity\PlageHoraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HoraireEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('hd', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('hf', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlageHoraire::class,
        ]);
    }
}
