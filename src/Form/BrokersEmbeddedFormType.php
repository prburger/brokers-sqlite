<?php

namespace App\Form;

use App\Entity\Broker;
use App\Repository\BrokerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class BrokersEmbeddedFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          
        ->add('name')
        ->add('select', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'I know, it\'s silly, but you must agree to our terms.'
                ])
            ]
        ]);

 /*    ->add('broker', EntityType::class, [
            'class' => Broker::class,
            'choice_label' => 'name',
            'query_builder' => function(BrokerRepository $repo) {
                return $repo->createQueryBuilder('b');
            }
        ]) 
        ; */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Broker::class,
        ]);
    }
}
