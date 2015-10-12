<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EvenementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'genemu_jquerydate', array( 
                                                    'widget' => 'single_text',
                                                    'format' => 'dd/MM/yyyy'
                                                    ))
            ->add('toDo', 'checkbox', array(
                                    'label' => 'à Faire ?',
                                    'required' => false))
            ->add('note')
            ->add('typeEvenement', 'entity', array(
                                            'class' => 'CandidaturesBundle:typeEvenement',
                                            'query_builder' => function(EntityRepository $er) {
                                                    return $er->createQueryBuilder('t')
                                                        ->orderBy('t.name', 'ASC');
                                                },
                                            'required' => true
                                            ))
            ->add('contact', 'genemu_jqueryselect2_entity', array(
                                        'class' => 'CandidaturesBundle:Contact',
                                        'query_builder' => function (EntityRepository $er) {
                                            return $er->createQueryBuilder('c')
                                                ->addOrderBy('c.firstName', 'ASC')
                                                ->addOrderBy('c.name', 'ASC');
                                        },
                                        'required' => false,
                                        ))
            ->add('candidature')
            ->add('documents', 'collection', array(
                    'type' => new DocumentType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nomaya_candidatures_candidaturesbundle_evenement';
    }
}
