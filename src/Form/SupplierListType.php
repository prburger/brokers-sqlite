<?php

namespace App\Form;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('name')
            ->add('supplierSelection', EntityType::class, 
                [
                    'required'=>false,
                    'multiple'=>true,
                    'label'=>false,
                    'class'=>Supplier::class, 
                    'choice_value' => function (?Supplier $supplier) {
                        return $supplier ? $supplier->getId() : '';
                    },
                    'choice_label'=> function ($supplier) {
                        return $supplier->getName();
                    },
                    // 'choices'=>$options['supplierSelection']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
            'supplierSelection'=>Collection::class    
        ]);
    }
}
