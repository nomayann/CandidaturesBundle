<?php
namespace Nomaya\Candidatures\CandidaturesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Nomaya\Candidatures\CandidaturesBundle\Entity\Candidature;
use Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement;
use Nomaya\Candidatures\CandidaturesBundle\Entity\Document;

class CandidatureUpdater
{
    public function postPersist(LifecycleEventArgs $args)
    {
    	$this->updateCandidature($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
    	$this->updateCandidature($args);
    }

    private function updateCandidature(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        # 
        if ($entity instanceof Evenement || $entity instanceof Document) {
            # mettre à jour la colonne updatedAt de la candidature liée à cet évènement
            $candidature = $entity->getCandidature();
            $candidature->setUpdatedAt( new \DateTime() );

            $em->persist($candidature);
            $em->flush();

        }
    }
}