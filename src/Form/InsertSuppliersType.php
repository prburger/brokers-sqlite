<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertSuppliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
     /*        ->add('name')
            ->add('dateAdded')
            ->add('dateEdited')
            ->add('contact')
            ->add('products')
            ->add('messages')
            ->add('broker') */
            ->add('supplierSelection', EntityType::class, 
            [
                'required'=>false,
                'multiple'=>true,
                'label'=>'Customers',
                'class'=>Customer::class, 
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
            'data_class' => Supplier::class,
        ]);
    }
}
