<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Videogame;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Videogame1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('releaseDate')
            ->add('name')
            ->add('imageFilename')
            ->add('categories', EntityType::class,[
                'class' => Category::class,
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Videogame::class,
        ]);
    }
}
