<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Marque;

/**
 * Modele
 *
 * @ORM\Table(name="modele")
 * @ORM\Entity(repositoryClass="App\Repository\ModeleRepository")
 */
class Modele
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
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="modeles", cascade={"persist"})
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id")
     */
    private $marque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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


}
