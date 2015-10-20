<?php

namespace NomayaCandidaturesBundle\Form\DataTransformer;

use NomayaCandidaturesBundle\Entity\Entreprise;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class EntrepriseToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (entreprise) to a string (number).
     *
     * @param  Entreprise|null $entreprise
     * @return string
     */
    public function transform($entreprise)
    {
        if (null === $entreprise) {
            return '';
        }

        return $entreprise->getId();
    }

    /**
     * Transforms a string (number) to an object (entreprise).
     *
     * @param  string $entrepriseNumber
     * @return Entreprise|null
     * @throws TransformationFailedException if object (entreprise) is not found.
     */
    public function reverseTransform($entrepriseNumber)
    {
        // no entreprise number? It's optional, so that's ok
        if (!$entrepriseNumber) {
            return;
        }

        $entreprise = $this->manager
            ->getRepository('CandidaturesBundle:Entreprise')
            // query for the Entreprise with this id
            ->find($entrepriseNumber)
        ;

        if (null === $entreprise) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An entreprise with number "%s" does not exist!',
                $entrepriseNumber
            ));
        }

        return $entreprise;
    }
}