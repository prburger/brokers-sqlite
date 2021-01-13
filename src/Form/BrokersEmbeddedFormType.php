<?php

namespace App\Form;

use App\Entity\Broker;
use App\Repository\BrokerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class BrokersEmbeddedFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['mapped' => true, 'label'=>false])
            ->add('id', TextType::class, ['mapped' => true, 'label'=>false])
         /*    ->add('remove', CollectionType::class, [
                'entry_type'=> CheckboxType::class, 
                'label'    => 'Remove',
                'required' => false,
            ]) */
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Broker::class,
        ]);
    }
}
