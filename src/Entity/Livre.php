<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 * @ORM\Table(name="livres")
 * @ORM\HasLifecycleCallbacks
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $auteur;

    /**
     * @Assert\DateTime
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=20)
     * @var string A "d-m-Y" formatted value
     */
    private $dateEdition;

    /**
     * @Assert\DateTime
     * @ORM\Column(type="string", length=20, options={"default": "CURRENT_TIMESTAMP"})
     * @var string A "d-m-Y H:i:s" formatted value
     */
    private $dateAjout;

    /**
     * @Assert\DateTime
     * @ORM\Column(type="string", length=20, options={"default": "CURRENT_TIMESTAMP"})
     * @var string A "d-m-Y H:i:s" formatted value
     */
    private $dateModif;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(){
        return $this->titre;
    }

    public function setTitre($titre){
        return $this->titre = $titre;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function setAuteur($auteur){
        return $this->auteur = $auteur;
    }

    public function getDateEdition(){
        return $dateEdition = $this->dateEdition;
    }

    public function setDateEdition($dateEdition){
        // $dateEditionFormat = $dateEdition->format("Y-m-d H:i:s");
        $dateEditionFormat = date("Y-m-d H:i:s", strtotime($dateEdition));

        return $this->dateEdition = $dateEditionFormat;
    }

    public function getDateAjout(){
        return $dateAjout = $this->dateAjout;
    }

    public function setDateAjout($dateAjout = "now"){
        $dateAjout = new \DateTime();
        $dateAjoutFormat = $dateAjout->format("Y-m-d H:i:s");

        return $this->dateAjout = $dateAjoutFormat;
    }

    public function getDateModif(){
        return $dateModif = $this->dateModif;
    }

    public function setDateModif($dateModif = "now"){
        $dateModif = new \DateTime();
        $dateModifFormat = $dateModif->format("Y-m-d H:i:s");
        
        return $this->dateModif = $dateModifFormat;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateDatetime(){
        if($this->getDateAjout() === null){
            $this->setDateAjout(new \DateTimeImmutable);
        }
        $this->setDateModif(new \DateTimeImmutable);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
