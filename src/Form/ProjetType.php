<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Projet;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('debut')
            ->add('fin')
            ->add('chargeTravail')
            ->add('repartition', ChoiceType::class,[
                'choices'=>[
                    'seul'=>'seul',
                    'groupe'=>'groupe',
                ]
            ])
            ->add('techno', EntityType::class, [
                'class' => 'App\Entity\Techno',
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('outils', EntityType::class, [
                'class' => 'App\Entity\Outils',
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('images', FileType::class, [
                'label' => 'images (PDF file)',
                'multiple' => true,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
            ])// ...
//            faire un form a par pour l'upload de fichier
            ->add('pdfName', FileType::class, [
                'label' => 'Brochure (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
            ])// ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
            'label' => false,
        ]);
    }
}