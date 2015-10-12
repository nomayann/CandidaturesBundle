<?php

namespace NomayaCandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entreprise
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NomayaCandidaturesBundle\Entity\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Title must not be empty")
     * @Assert\Length(
     *      min=3,
     *      max=255,
     *      minMessage="Le nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
     *
     * @Assert\Regex(
     *      pattern = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/",
     *      message = "'{{ value }}' n'est pas un numéro de téléphone valide."
     * )
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     *
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100, nullable=true)
     *
     * @Assert\Url(
     * message = "'{{ value }}' n'est pas un site web valide."
     * )
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=10, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="effective", type="integer", nullable=true)
     *
     * @Assert\GreaterThan(
     *     value = 1
     * )
     */
    private $effective;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true, nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="pros", type="string", length=255, nullable=true)
     */
    private $pros;

    /**
     * @var string
     *
     * @ORM\Column(name="cons", type="string", length=255, nullable=true)
     */
    private $cons;

    /**
     * @ORM\OneToMany(targetEntity="Candidature", mappedBy="entreprise")
     */
    protected $candidatures;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="entreprise")
     */
    protected $contacts;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
        $this->contacts = new ArrayCollection();

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
     * @return Entreprise
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
     * Set tel
     *
     * @param string $tel
     * @return Entreprise
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Entreprise
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Entreprise
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Entreprise
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Entreprise
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Entreprise
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Entreprise
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set effective
     *
     * @param integer $effective
     * @return Entreprise
     */
    public function setEffective($effective)
    {
        $this->effective = $effective;

        return $this;
    }

    /**
     * Get effective
     *
     * @return integer 
     */
    public function getEffective()
    {
        return $this->effective;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Entreprise
     */
    public function setNotes($notes)
    {
        // Nettoie la chaîne des retours à la ligne répétés
        $this->notes = preg_replace ("/(\n|\r){3,}/","\n\n", $notes);

        $this->notes = trim( $this->notes );

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set pros
     *
     * @param string $pros
     * @return Entreprise
     */
    public function setPros($pros)
    {
        $this->pros = $pros;

        return $this;
    }

    /**
     * Get pros
     *
     * @return string 
     */
    public function getPros()
    {
        return $this->pros;
    }

    /**
     * Set cons
     *
     * @param string $cons
     * @return Entreprise
     */
    public function setCons($cons)
    {
        $this->cons = $cons;

        return $this;
    }

    /**
     * Get cons
     *
     * @return string 
     */
    public function getCons()
    {
        return $this->cons;
    }

    /**
     * Add candidatures
     *
     * @param \NomayaCandidaturesBundle\Entity\Candidature $candidatures
     * @return Entreprise
     */
    public function addCandidature(\NomayaCandidaturesBundle\Entity\Candidature $candidatures)
    {
        $this->candidatures[] = $candidatures;

        return $this;
    }

    /**
     * Remove candidatures
     *
     * @param \NomayaCandidaturesBundle\Entity\Candidature $candidatures
     */
    public function removeCandidature(\NomayaCandidaturesBundle\Entity\Candidature $candidatures)
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

    /**
     * Add contacts
     *
     * @param \NomayaCandidaturesBundle\Entity\Contact $contacts
     * @return Entreprise
     */
    public function addContact(\NomayaCandidaturesBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \NomayaCandidaturesBundle\Entity\Contact $contacts
     */
    public function removeContact(\NomayaCandidaturesBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
