<?php

namespace NomayaCandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use NomayaCandidaturesBundle\Form\DataTransformer\CandidatureToNumberTransformer;

class EvenementType extends AbstractType
{
    /**
     * @param ObjectManager $manager
     * @param array $mainOptions
     */    
    public function __construct(ObjectManager $manager, array $mainOptions = array())
    {
        $this->manager = $manager;
        $this->mainOptions = $mainOptions;
    }

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
            ->add('documents', 'collection', array(
                    'type' => new DocumentType($this->manager, array(
                                                                    'candidature' => 'hide',
                                                                    'evenement' => 'hide')),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    ))
            ;
            if( array_key_exists('candidature', $this->mainOptions) 
            && $this->mainOptions['candidature'] == 'hide' )
            {
                $builder->add('candidature','hidden', array(
                                            'required' => false,
                                            'invalid_message' => 'La candidature liée n\'a pas pu être identifiée'
                                            ));

                $builder->get('candidature')
                    ->addModelTransformer(new CandidatureToNumberTransformer($this->manager));
            } else
            {
                $builder->add('candidature');
            }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NomayaCandidaturesBundle\Entity\Evenement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'candidaturesbundle_evenement';
    }
}
