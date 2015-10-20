<?php

namespace NomayaCandidaturesBundle\Form\DataTransformer;

use NomayaCandidaturesBundle\Entity\Evenement;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class EvenementToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (evenement) to a string (number).
     *
     * @param  Evenement|null $evenement
     * @return string
     */
    public function transform($evenement)
    {
        if (null === $evenement) {
            return '';
        }

        return $evenement->getId();
    }

    /**
     * Transforms a string (number) to an object (evenement).
     *
     * @param  string $evenementNumber
     * @return Evenement|null
     * @throws TransformationFailedException if object (evenement) is not found.
     */
    public function reverseTransform($evenementNumber)
    {
        // no evenement number? It's optional, so that's ok
        if (!$evenementNumber) {
            return;
        }

        $evenement = $this->manager
            ->getRepository('CandidaturesBundle:Evenement')
            // query for the Evenement with this id
            ->find($evenementNumber)
        ;

        if (null === $evenement) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A evenement with number "%s" does not exist!',
                $evenementNumber
            ));
        }

        return $evenement;
    }
}