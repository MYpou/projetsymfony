<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Nom du livre : ",
                'required' => true
            ])
            ->add('price', MoneyType::class, [
                'label' => "Prix du livre : ",
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description du livre : ",
                'required' => false
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => "URL de l'image du livre : ",
                'required' => false
            ])
            ->add('send', SubmitType::class, [
                'label' => "Valider"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
