<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertCustomersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
/*             ->add('name')
            ->add('dateAdded')
            ->add('dateEdited')
            ->add('contact')
            ->add('products')
            ->add('brokers')
            ->add('messages') */
            ->add('customers', ChoiceType::class, 
            [
                'required'=>false,
                'multiple'=>true,
                'label'=>'Customers',
                'choice_value' => 'name',
                'choice_label'=> function ($customer) {
                    return $customer->getName();
                },
/*                 'choices' => function (?Customer $customer) {
                    return $customer ? $customer->getName() : '';
                }, */
                // 'choices'=>$options['name']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
