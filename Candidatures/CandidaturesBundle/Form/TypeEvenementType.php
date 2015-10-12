<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeEvenementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nomaya\Candidatures\CandidaturesBundle\Entity\TypeEvenement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nomaya_candidatures_candidaturesbundle_typeevenement';
    }
}
