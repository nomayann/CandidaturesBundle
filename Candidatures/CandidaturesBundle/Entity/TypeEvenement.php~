<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TypeEvenement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nomaya\Candidatures\CandidaturesBundle\Entity\TypeEvenementRepository")
 */
class TypeEvenement
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
     * )     
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="typeEvenement", cascade={"persist"})
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
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
     * @return TypeEvenement
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
     * Add evenements
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement $evenements
     * @return TypeEvenement
     */
    public function addEvenement(\Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement $evenements)
    {
        $this->evenements[] = $evenements;

        return $this;
    }

    /**
     * Remove evenements
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement $evenements
     */
    public function removeEvenement(\Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement $evenements)
    {
        $this->evenements->removeElement($evenements);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvenements()
    {
        return $this->evenements;
    }
}
