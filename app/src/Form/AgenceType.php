<?php

namespace App\Form;

use App\Entity\Agence;
use App\Entity\Annonce;
use App\Entity\Capacite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('codeAgence')
            ->add('capacites', EntityType::class, [
                'class' => Capacite::class,
                'choice_label' => 'capacite',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => '']
            ])
            ->add('enregistrer', SubmitType::class)
//            ->add('annonces', EntityType::class, [
//                'class' => Annonce::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}
