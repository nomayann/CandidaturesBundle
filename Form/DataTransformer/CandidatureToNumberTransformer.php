<?php

namespace NomayaCandidaturesBundle\Form\DataTransformer;

use NomayaCandidaturesBundle\Entity\Candidature;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class CandidatureToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (candidature) to a string (number).
     *
     * @param  Candidature|null $candidature
     * @return string
     */
    public function transform($candidature)
    {
        if (null === $candidature) {
            return '';
        }

        return $candidature->getId();
    }

    /**
     * Transforms a string (number) to an object (candidature).
     *
     * @param  string $candidatureNumber
     * @return Candidature|null
     * @throws TransformationFailedException if object (candidature) is not found.
     */
    public function reverseTransform($candidatureNumber)
    {
        // no candidature number? It's optional, so that's ok
        if (!$candidatureNumber) {
            return;
        }

        $candidature = $this->manager
            ->getRepository('CandidaturesBundle:Candidature')
            // query for the Candidature with this id
            ->find($candidatureNumber)
        ;

        if (null === $candidature) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A candidature with number "%s" does not exist!',
                $candidatureNumber
            ));
        }

        return $candidature;
    }
}