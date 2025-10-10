<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Book Name",
                'attr' => [
                    'placeholder' => 'ex: Lord of The Rings: The Two Towers'
                ],
            ])
            ->add('sinopse', TextType::class, [
                'label' => "Sinopse",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Be creative!"
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => "form-select",
                ]
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => "form-select"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
