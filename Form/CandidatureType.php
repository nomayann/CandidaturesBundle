<?php

namespace NomayaCandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class CandidatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeCandidature')
            ->add('refOffre', 'text', array(
                                'label' => 'Référence',
                                'required' => false
                                ))
            ->add('libOffre', 'text', array('label' => 'Libellé'))
            ->add('dateOffre', 'genemu_jquerydate', array( 
                                                    'widget' => 'single_text',
                                                    'format' => 'dd/MM/yyyy'
                                                    ))
            ->add('urlOffre', 'text', array('required' => false,
                                            'label' => 'url de l\'offre'))
            ->add('note')
            ->add('status')
            ->add('entreprise', 'genemu_jqueryselect2_entity', array(
                                    'class' => 'CandidaturesBundle:Entreprise',
                                    'query_builder' => function(EntityRepository $er) 
                                        {
                                            return $er->createQueryBuilder('e')
                                                    ->orderBy('e.name', 'ASC');
                                        }
                                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NomayaCandidaturesBundle\Entity\Candidature'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'candidaturesbundle_candidature';
    }
}
