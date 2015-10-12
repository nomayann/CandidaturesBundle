<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TypeCandidature
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nomaya\Candidatures\CandidaturesBundle\Entity\TypeCandidatureRepository")
 */
class TypeCandidature
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     *
     * @Assert\Length(
     *      min=5,
     *      max=50,
     *      minMessage="Le nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères"
     * )      */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Candidature", mappedBy="typeCandidature", cascade={"persist"})
     */
    protected $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TypeCandidature
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add candidatures
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Candidature $candidatures
     * @return TypeCandidature
     */
    public function addCandidature(\Nomaya\Candidatures\CandidaturesBundle\Entity\Candidature $candidatures)
    {
        $this->candidatures[] = $candidatures;

        return $this;
    }

    /**
     * Remove candidatures
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Candidature $candidatures
     */
    public function removeCandidature(\Nomaya\Candidatures\CandidaturesBundle\Entity\Candidature $candidatures)
    {
        $this->candidatures->removeElement($candidatures);
    }

    /**
     * Get candidatures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }
}
