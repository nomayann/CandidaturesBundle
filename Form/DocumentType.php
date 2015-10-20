<?php

namespace NomayaCandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NomayaCandidaturesBundle\Form\DataTransformer\CandidatureToNumberTransformer;
use NomayaCandidaturesBundle\Form\DataTransformer\EvenementToNumberTransformer;

class DocumentType extends AbstractType
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
            ->add('name')
            ->add('file', 'file', array(
                                'label'     => 'Fichier'
                                ));
        if( array_key_exists('evenement', $this->mainOptions) 
            && $this->mainOptions['evenement'] == 'hide' )
        {
            $builder->add('evenement','hidden', array(
                                        'required' => false,
                                        'invalid_message' => 'L\'évènement lié n\'a pas pu être identifiée'
                                        ));
            $builder->get('evenement')
                ->addModelTransformer(new EvenementToNumberTransformer($this->manager));
        } else
        {
            $builder->add('evenement');
        }
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
            'data_class' => 'NomayaCandidaturesBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'candidaturesbundle_document';
    }
}
