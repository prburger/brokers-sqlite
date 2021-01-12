<?php

namespace App\Form;

use App\Entity\Message;
use App\Form\BrokersEmbeddedFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sentBy')
            ->add('text', TextareaType::class,['attr'=>['class'=>'tinymce','rows'=>10],])
         
             ->add('brokers', CollectionType::class, [
                'entry_type' => BrokersEmbeddedFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'mapped' => true
            ])
            ->add('customers', CollectionType::class, [
                'entry_type' => CustomersEmbeddedFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'mapped' => true
            ])              
            ->add('suppliers', CollectionType::class, [
                'entry_type' => SuppliersEmbeddedFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'mapped' => true
            ]) 
      ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
