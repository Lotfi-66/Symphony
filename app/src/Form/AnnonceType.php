<?php

namespace App\Form;

use App\Entity\Agence;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Equipement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('prix')
            ->add('ville')
            ->add('codePostal')
            ->add('dpe', ChoiceType::class, [
                "label" => "Diagnostique Energie",
                'choices' => [
                    "A"=>"A", "B"=>"B", "C"=>"C",
                    "D"=>"D", "E"=>"E", "F"=>"G",
                    "G"=>"G",
                ]
            ])
            ->add('surface')
            ->add('nbrPiece')
//            ->add('isExclusive',ChoiceType::class,[
//                'label' => "active",
//                "choices" => ["oui" => true, "non"=>false],
//                "multiple" => true,
//                'expanded' => false,
//                'choices_as_value' => true
//            ])
//            ->add('isRental',CheckboxType::class,[
//                'label' => "est à louer"
//            ])
            ->add('datePublication', null, [
                'widget' => 'single_text',
            ])
            ->add('agences', EntityType::class, [
                'class' => Agence::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'libelle',
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
