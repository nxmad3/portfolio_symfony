<?php

namespace App\Form;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Projet;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('debut')
            ->add('fin')
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
            ->add('image', ImageType::class)
            ->add('pdf', PdfType::class);
    }
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Projet::class,
            ]);
        }
    }