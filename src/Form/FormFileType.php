<?php

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FormFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName', TextType::class, array('required' =>false))
            ->add('fileType', TextType::class, array('required' =>false))
            ->add('fileDescription', TextType::class, array('required' =>false))
            ->add('fileSize', TextType::class, array('required' =>false, 'attr' => array('readonly' => true)))
            ->add('file', FileType::class, array('label' => 'File', 'mapped' =>false, 'required' => false))
            ->add('Upload', submitType::class, array('label' => 'Upload'))
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => File::class,
        ]);
    }
}
