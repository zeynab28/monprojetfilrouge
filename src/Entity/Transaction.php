<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetransaction;

    /**
     * @ORM\Column(type="bigint")
     */
    private $codetransaction;

    /**
     * @ORM\Column(type="bigint")
     */
    private $montant;

    /**
     * @ORM\Column(type="bigint")
     */
    private $comenvoi;

    /**
     * @ORM\Column(type="bigint")
     */
    private $comretrait;

    /**
     * @ORM\Column(type="bigint")
     */
    private $cometat;

    /**
     * @ORM\Column(type="bigint")
     */
    private $comsystem;

    /**
     * @ORM\Column(type="bigint")
     */
    private $frais;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDatetransaction(): ?\DateTimeInterface
    {
        return $this->datetransaction;
    }

    public function setDatetransaction(\DateTimeInterface $datetransaction): self
    {
        $this->datetransaction = $datetransaction;

        return $this;
    }

    public function getCodetransaction(): ?int
    {
        return $this->codetransaction;
    }

    public function setCodetransaction(int $codetransaction): self
    {
        $this->codetransaction = $codetransaction;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getComenvoi(): ?int
    {
        return $this->comenvoi;
    }

    public function setComenvoi(int $comenvoi): self
    {
        $this->comenvoi = $comenvoi;

        return $this;
    }

    public function getComretrait(): ?int
    {
        return $this->comretrait;
    }

    public function setComretrait(int $comretrait): self
    {
        $this->comretrait = $comretrait;

        return $this;
    }

    public function getCometat(): ?int
    {
        return $this->cometat;
    }

    public function setCometat(int $cometat): self
    {
        $this->cometat = $cometat;

        return $this;
    }

    public function getComsystem(): ?int
    {
        return $this->comsystem;
    }

    public function setComsystem(int $comsystem): self
    {
        $this->comsystem = $comsystem;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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
