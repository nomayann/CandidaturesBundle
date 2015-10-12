<?php

namespace NomayaCandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Evenement
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="NomayaCandidaturesBundle\Entity\EvenementRepository")
 */
class Evenement
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="to_do", type="boolean", nullable=true, options={"default" = false}))
     */
    private $toDo;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="TypeEvenement", inversedBy="evenements")
     */
    private $typeEvenement;

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="evenements")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="Candidature", inversedBy="evenements")
     */
    private $candidature;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="evenement", orphanRemoval=true, cascade={"all"})
     */
    protected $documents;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function __toString()
    {
        return 'evenement '.$this->id;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Evenement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Evenement
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set typeEvenement
     *
     * @param \NomayaCandidaturesBundle\Entity\TypeEvenement $typeEvenement
     * @return Evenement
     */
    public function setTypeEvenement(\NomayaCandidaturesBundle\Entity\TypeEvenement $typeEvenement = null)
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    /**
     * Get typeEvenement
     *
     * @return \NomayaCandidaturesBundle\Entity\TypeEvenement 
     */
    public function getTypeEvenement()
    {
        return $this->typeEvenement;
    }

    /**
     * Set contact
     *
     * @param \NomayaCandidaturesBundle\Entity\Contact $contact
     * @return Evenement
     */
    public function setContact(\NomayaCandidaturesBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \NomayaCandidaturesBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set candidature
     *
     * @param \NomayaCandidaturesBundle\Entity\Candidature $candidature
     * @return Evenement
     */
    public function setCandidature(\NomayaCandidaturesBundle\Entity\Candidature $candidature = null)
    {
        $this->candidature = $candidature;

        return $this;
    }

    /**
     * Get candidature
     *
     * @return \NomayaCandidaturesBundle\Entity\Candidature 
     */
    public function getCandidature()
    {
        return $this->candidature;
    }

    /**
     * Add documents
     *
     * @param \NomayaCandidaturesBundle\Entity\Document $documents
     * @return Evenement
     */
    public function addDocument(\NomayaCandidaturesBundle\Entity\Document $document)
    {
        // Assure l'enregistrement de la clé étrangère
        $document->setEvenement($this);

        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \NomayaCandidaturesBundle\Entity\Document $documents
     */
    public function removeDocument(\NomayaCandidaturesBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Candidature
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt( new \DateTime() );
    }

    /**
     * Set toDo
     *
     * @param boolean $toDo
     * @return Evenement
     */
    public function setToDo($toDo)
    {
        $this->toDo = $toDo;

        return $this;
    }

    /**
     * Get toDo
     *
     * @return boolean 
     */
    public function getToDo()
    {
        return $this->toDo;
    }
}
