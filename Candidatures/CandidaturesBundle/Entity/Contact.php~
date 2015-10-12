<?php

namespace Nomaya\Candidatures\CandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nomaya\Candidatures\CandidaturesBundle\Entity\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="civility", type="string", length=10, nullable=true)
     *
     * @Assert\Choice(choices = {"M.", "Mme", "Mle"}, message = "Choisissez une civilité valide.")
     *
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=70)
     *
     * @Assert\Length(
     *      min=3,
     *      max=70,
     *      minMessage="Le nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=70)
     *
     * @Assert\Length(
     *      min=3,
     *      max=70,
     *      minMessage="Le prénom doit faire au moins {{ limit }} caractères.",
     *      maxMessage="Le prénom ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=100, nullable=true)
     */
    private $function;

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
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
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
     * @ORM\Column(name="note", type="text", nullable=true)
     *
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="contacts")
     * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     */
    protected $entreprise;


    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="contact")
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();

    }

    public function __toString()
    {
        return $this->firstName.' '.$this->name.'('.$this->entreprise.')';

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
     * @return Contact
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
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set function
     *
     * @param string $function
     * @return Contact
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string 
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Contact
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
     * @return Contact
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
     * Set note
     *
     * @param string $note
     * @return Contact
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
     * Set entreprise
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Entreprise $entreprise
     * @return Contact
     */
    public function setEntreprise(\Nomaya\Candidatures\CandidaturesBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \Nomaya\Candidatures\CandidaturesBundle\Entity\Entreprise 
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Add evenements
     *
     * @param \Nomaya\Candidatures\CandidaturesBundle\Entity\Evenement $evenements
     * @return Contact
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

    /**
     * Set civility
     *
     * @param string $civility
     * @return Contact
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string 
     */
    public function getCivility()
    {
        return $this->civility;
    }
}
