<?php

namespace App\Form;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Message;
use App\Entity\Supplier;
use App\Form\BrokersEmbeddedFormType;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\SupplierRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('brokerSelection', EntityType::class, 
                [
                    'choice_attr' => function() {
                        return ['checked' => 'checked'];
                    },
                    'multiple'=>true,
                    'label'=>false,
                    'class'=>Broker::class, 
                    'choice_label' => function ($broker) {
                        return $broker->getName();
                    },
                    'choice_value' => function (?Broker $broker) {
                        return $broker ? $broker->getId() : '';
                    },
                    'query_builder' => function (BrokerRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.dateAdded', 'ASC');},
                ])
            ->add('customerSelection', EntityType::class, 
                [
                    'multiple'=>true,
                    'label'=>false,
                    'class'=>Customer::class, 
                    'choice_value' => function (?Customer $customer) {
                        return $customer ? $customer->getId() : '';
                    },
                    'choice_label'=> function ($customer) {
                        return $customer->getName();
                    },
                    'query_builder' => function (CustomerRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.dateAdded', 'ASC');},
                ])
            ->add('supplierSelection', EntityType::class, 
                [
                    'multiple'=>true,
                    'label'=>false,
                    'class'=>Supplier::class, 
                    'choice_value' => function (?Supplier $supplier) {
                        return $supplier ? $supplier->getId() : '';
                    },
                    'choice_label'=> function ($supplier) {
                        return $supplier->getName();
                    }, 
                    'query_builder' => function (SupplierRepository $er) {
                        return $er->createQueryBuilder('u')
                        ->orderBy('u.dateAdded', 'ASC');}
                ])
            
             ->add('brokers', CollectionType::class, [
                'entry_type' => BrokersEmbeddedFormType::class,
                'entry_options' => ['label'=>false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype'=>true,
                'mapped' => true
            ])
            ->add('customers', CollectionType::class, [
                'entry_type' => CustomersEmbeddedFormType::class,
                'allow_add' => true,
                'entry_options' => ['label'=>false],
                'allow_delete' => true,
                'by_reference' => false,
                'prototype'=>true,
                'mapped' => true
            ])              
            ->add('suppliers', CollectionType::class, [
                'entry_type' => SuppliersEmbeddedFormType::class,
                'allow_add' => true,
                'entry_options' => ['label'=>false],
                'allow_delete' => true,
                'by_reference' => false,
                'mapped' => true,
                'prototype'=>true
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
