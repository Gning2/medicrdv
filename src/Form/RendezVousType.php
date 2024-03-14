<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_patient', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('prenom_patient', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('service', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('num_tel', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('email_patient', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('adresse', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('date_rdv', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('heure_res', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('sexe', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('age', TextType::class, ['attr' =>['class'=>'form-control']])
            ->add('motif', TextareaType::class, ['attr' =>['class'=>'form-control areamotif']] )
            ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
