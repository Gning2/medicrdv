<?php

namespace App\Form;

use App\Entity\PlageHoraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlageHoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour',ChoiceType::class,  [
    'choices'  => [
        'Lundi' => 'Lundi',
        'Mardi' => 'Mardi',
        'Mercredi' => 'Mercredi',
        'Jeudi' => 'Jeudi',
        'Vendredi' => 'vendredi',
        'Samedi' => 'Samedi',
    ],
],['attr' =>['class'=>'form-control']])
            ->add('hf',ChoiceType::class,  [
                'choices'  => [
                    '08:00' => '08:00',
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '12:00' => '12:00',
                    '13:00' => '13:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                    '17:00' => '17:00',
                    '18:00' => '18:00',
                    '19:00' => '19:00',
                ],
            ],['attr' =>['class'=>'form-control']])
            ->add('hd',ChoiceType::class,  [
                'choices'  => [
                    '08:00' => '08:00',
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '12:00' => '12:00',
                    '13:00' => '13:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                    '17:00' => '17:00',
                    '18:00' => '18:00',
                    '19:00' => '19:00',
                ],
            ],['attr' =>['class'=>'form-control']])
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
