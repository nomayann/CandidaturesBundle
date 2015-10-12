<?php

namespace NomayaCandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Candidature
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="NomayaCandidaturesBundle\Entity\CandidatureRepository")
 */
class Candidature
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
     * @ORM\Column(name="ref_offre", type="string", length=50, nullable=true)
     */
    private $refOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_offre", type="string", length=255)
     *
     * @Assert\Length(
     *      min=10,
     *      max=255,
     *      minMessage="Le libellé doit faire au moins {{ limit }} caractères.",
     *      maxMessage="Le libellé ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $libOffre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_offre", type="datetime")
     */
    private $dateOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="url_offre", type="string", length=255, nullable=true)
     *
     * @Assert\Url(
     * message = "'{{ value }}' n'est pas un site web valide."
     * )
     */
    private $urlOffre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true, options={"default" = true}))
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="candidatures")
     * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     *
     */
    protected $entreprise;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="candidature", orphanRemoval=true, cascade={"all"})
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="candidature", orphanRemoval=true, cascade={"all"})
     */
    protected $evenements;

    /**
     * @ORM\ManyToOne(targetEntity="TypeCandidature", inversedBy="candidatures")
     */
    private $typeCandidature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->evenements = new ArrayCollection();
        // Valeur par défaut du statut
        if(is_null($this->getStatus()))
            $this->setStatus(true);

    }

    public function __toString()
    {
        $ref = $this->refOffre? ' ('.$this->refOffre.')' : '';
        return $this->libOffre.$ref;
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
     * Set refOffre
     *
     * @param string $refOffre
     * @return Candidature
     */
    public function setRefOffre($refOffre)
    {
        $this->refOffre = $refOffre;

        return $this;
    }

    /**
     * Get refOffre
     *
     * @return string 
     */
    public function getRefOffre()
    {
        return $this->refOffre;
    }

    /**
     * Set libOffre
     *
     * @param string $libOffre
     * @return Candidature
     */
    public function setLibOffre($libOffre)
    {
        $this->libOffre = $libOffre;

        return $this;
    }

    /**
     * Get libOffre
     *
     * @return string 
     */
    public function getLibOffre()
    {
        return $this->libOffre;
    }

    /**
     * Set dateOffre
     *
     * @param \DateTime $dateOffre
     * @return Candidature
     */
    public function setDateOffre($dateOffre)
    {
        $this->dateOffre = $dateOffre;

        return $this;
    }

    /**
     * Get dateOffre
     *
     * @return \DateTime 
     */
    public function getDateOffre()
    {
        return $this->dateOffre;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Candidature
     */
    public function setNote($note)
    {
        // Nettoie la chaîne des retours à la ligne répétés
        $this->note = preg_replace ("/(\n|\r){3,}/","\n\n", $note);

        $this->note = trim( $this->note );

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
     * Set status
     *
     * @param boolean $status
     * @return Candidature
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set entreprise
     *
     * @param \NomayaCandidaturesBundle\Entity\Entreprise $entreprise
     * @return Candidature
     */
    public function setEntreprise(\NomayaCandidaturesBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \NomayaCandidaturesBundle\Entity\Entreprise 
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Add documents
     *
     * @param \NomayaCandidaturesBundle\Entity\Document $documents
     * @return Candidature
     */
    public function addDocument(\NomayaCandidaturesBundle\Entity\Document $document)
    {
        // Assure l'enregistrement de la clé étrangère
        $document->setCandidature($this);

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
     * Add evenements
     *
     * @param \NomayaCandidaturesBundle\Entity\Evenement $evenements
     * @return Candidature
     */
    public function addEvenement(\NomayaCandidaturesBundle\Entity\Evenement $evenements)
    {
        $this->evenements[] = $evenements;

        return $this;
    }

    /**
     * Remove evenements
     *
     * @param \NomayaCandidaturesBundle\Entity\Evenement $evenements
     */
    public function removeEvenement(\NomayaCandidaturesBundle\Entity\Evenement $evenements)
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

    /**
     * Set typeCandidature
     *
     * @param \NomayaCandidaturesBundle\Entity\TypeCandidature $typeCandidature
     * @return Evenement
     */
    public function setTypeCandidature(\NomayaCandidaturesBundle\Entity\TypeCandidature $typeCandidature = null)
    {
        $this->typeCandidature = $typeCandidature;

        return $this;
    }

    /**
     * Get typeCandidature
     *
     * @return \NomayaCandidaturesBundle\Entity\TypeCandidature 
     */
    public function getTypeCandidature()
    {
        return $this->typeCandidature;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Candidature
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->setCreatedAt( new \DateTime() );
    }

    /**
     * Set urlOffre
     *
     * @param string $urlOffre
     * @return Candidature
     */
    public function setUrlOffre($urlOffre)
    {
        $this->urlOffre = $urlOffre;

        return $this;
    }

    /**
     * Get urlOffre
     *
     * @return string 
     */
    public function getUrlOffre()
    {
        return $this->urlOffre;
    }
}
