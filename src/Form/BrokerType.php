<?php

namespace App\Form;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Supplier;
use App\Form\ContactFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrokerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('contact', ContactFormType::class,['label'=>false])
            ->add('brokerSelection', EntityType::class, 
            [
                'required'=>false,
                'multiple'=>true,
                'expanded'=>false,
                'label'=>'Brokers',
                'class'=>Broker::class, 
                'choice_label' => function ($broker) { return $broker->getName();},
                'choice_value' => function (?Broker $broker) { return $broker ? $broker->getId() : '';},
                'choices'=>$options['brokerSelection']
            ])
        ->add('customerSelection', EntityType::class, 
            [
                'required'=>false,
                'multiple'=>true,
                'label'=>'Customers',
                'class'=>Customer::class, 
                'choice_value' => function (?Customer $customer) {
                    return $customer ? $customer->getId() : '';
                },
                'choice_label'=> function ($customer) {
                    return $customer->getName();
                },
                'choices'=>$options['customerSelection']
            ])
        ->add('supplierSelection', EntityType::class, 
            [
                'required'=>false,
                'multiple'=>true,
                'label'=>'Suppliers',
                'class'=>Supplier::class, 
                'choice_value' => function (?Supplier $supplier) {
                    return $supplier ? $supplier->getId() : '';
                },
                'choice_label'=> function ($supplier) {
                    return $supplier->getName();
                },
                'choices'=>$options['supplierSelection']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Broker::class,
            'brokerSelection'=>Collection::class,
            'customerSelection'=>Collection::class,
            'supplierSelection'=>Collection::class  
        ]);
    }
}
