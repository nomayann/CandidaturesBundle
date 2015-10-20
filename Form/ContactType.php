<?php

namespace NomayaCandidaturesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use NomayaCandidaturesBundle\Form\DataTransformer\EntrepriseToNumberTransformer;

class ContactType extends AbstractType
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
            ->add('civility', 'genemu_jqueryselect2_choice', array(
                                        'choices'   => array('M.' => 'Monsieur', 'Mme' => 'Madame', 'Mle' => 'Mademoiselle'),
                                        'required'  => false,
                                        'label'     => 'Civilité'
                                        ))
            ->add('firstName', 'text', array(
                                        'label' => "Prénom",
                                        'trim'  => true
                                        ))
            ->add('name', 'text', array(
                                        'label' => "Nom",
                                        'trim'  => true
                                        ))
            ->add('function', 'text', array(
                                        'label' => "Fonction",
                                        'trim'  => true,
                                        'required' => false,
                                        ))
            ->add('tel', 'text', array(
                                        'trim'  => true,
                                        'required' => false,
                                        ))
            ->add('email', 'text', array(
                                        'trim' => true,
                                        'required' => false,
                                        ))
            ->add('note', 'textarea', array(
                                        'trim' => true,
                                        'required' => false
                                        ));
            if( array_key_exists('entreprise', $this->mainOptions) 
                && $this->mainOptions['entreprise'] == 'hide' )
            {
                $builder->add('entreprise', 'hidden');
                $builder->get('entreprise')
                        ->addModelTransformer(new EntrepriseToNumberTransformer($this->manager));
            } else
            {
                $builder->add('entreprise', 'genemu_jqueryselect2_entity', array(
                                        'class'=>'CandidaturesBundle:Entreprise',
                                        'query_builder' => function(EntityRepository $er) 
                                            {
                                                return $er->createQueryBuilder('e')
                                                        ->orderBy('e.name', 'ASC');
                                            },
                                        'label'=>'Entreprise',
                                        ));   
            }
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NomayaCandidaturesBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'candidaturesbundle_contact';
    }
}
