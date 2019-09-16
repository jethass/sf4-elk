<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Image;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture")
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Voiture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="carburant", type="string", length=255, nullable=false)
     */
    private $carburant;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometrage", type="integer", nullable=false)
     */
    private $kilometrage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_circulation", type="datetime", nullable=false)
     */
    private $dateCirculation;

    /**
     * @var string
     *
     * @ORM\Column(name="boite_vitesse", type="string", length=255, nullable=false)
     */
    private $boiteVitesse;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_de_porte", type="integer", nullable=false)
     */
    private $nombreDePorte;

    /**
     * @var int
     *
     * @ORM\Column(name="puissance_fiscal", type="integer", nullable=false)
     */
    private $puissanceFiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255, nullable=false)
     */
    private $couleur;

    /**
     * @var bool
     *
     * @ORM\Column(name="premiere_main", type="boolean", nullable=false)
     */
    private $premiereMain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", cascade={"persist"})
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id")
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modele", cascade={"persist"})
     * @ORM\JoinColumn(name="modele_id", referencedColumnName="id")
     */
    private $modele;


    /**
     * Many Images have one Folder
     * @ORM\OneToMany(targetEntity="Image", mappedBy="voiture", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();

        $this->setDateCreated(new \DateTime());

        if ($this->getDateModified() == null) {
            $this->setDateModified(new \DateTime());
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime() {
        $this->setDateModified(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }


    public function getBoiteVitesse(): ?string
    {
        return $this->boiteVitesse;
    }

    public function setBoiteVitesse(string $boiteVitesse): self
    {
        $this->boiteVitesse = $boiteVitesse;

        return $this;
    }

    public function getNombreDePorte(): ?int
    {
        return $this->nombreDePorte;
    }

    public function setNombreDePorte(int $nombreDePorte): self
    {
        $this->nombreDePorte = $nombreDePorte;

        return $this;
    }

    public function getPuissanceFiscal(): ?int
    {
        return $this->puissanceFiscal;
    }

    public function setPuissanceFiscal(int $puissanceFiscal): self
    {
        $this->puissanceFiscal = $puissanceFiscal;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPremiereMain(): ?bool
    {
        return $this->premiereMain;
    }

    public function setPremiereMain(bool $premiereMain): self
    {
        $this->premiereMain = $premiereMain;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

   public function getDateCirculation(): ?\DateTimeInterface
    {
        return $this->dateCirculation;
    }

    public function setDateCirculation(\DateTimeInterface $dateCirculation): self
    {
        $this->dateCirculation = $dateCirculation;

        return $this;
    }

    /**
     * Add image
     *
     * @param \App\Entity\Image $image
     *
     * @return Image
     */
    public function addImage(\App\Entity\Image $image)
    {
        $image->setVoiture($this);
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \App\Entity\Image $image
     */
    public function removeImage(\App\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
     * Add tag
     *
     * @param \App\Entity\Tag $tag
     *
     * @return Tag
     */
    public function addTag(\App\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \App\Entity\Tag $tag
     */
    public function removeTag(\App\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
