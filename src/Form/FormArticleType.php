<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FormArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->upOrAdd = $options['upOrAdd'];
        $builder
            ->add('title', TextType::class, array('required' =>false))
            ->add('content', TextareaType::class, array('required' =>false))
            ->add('isPublic', CheckboxType::class, array('required' =>false))
            ->add('slug', TextType::class, array('required' =>false))
            ->add('attachment', FileType::class, array('mapped' => false))
            ->add('Publish', submitType::class, array('label' => $options['upOrAdd']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Article::class,
            'upOrAdd'=>'Add',
            
        ]);
    }
}
