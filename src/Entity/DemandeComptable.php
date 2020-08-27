<?php

namespace App\Entity;

use App\Repository\DemandeComptableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeComptableRepository::class)
 */
class DemandeComptable
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
    private $object;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="demandeComptables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $createdat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $holidaysrequest;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hoursrequest;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hourssupp;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $money;

    /**
    * La comptable accepte la demande
    * @return DemandeComptable
    */
    public function acceptdemande()
    {
        $this->accepted = true;

        return $this;
    }

    /**
    * La comptable refuse la demande
    * @return DemandeComptable
    */
    public function refusedemande() 
    {
        $this->accepted = false;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getHolidaysrequest(): ?float
    {
        return $this->holidaysrequest;
    }

    public function setHolidaysrequest(?float $holidaysrequest): self
    {
        $this->holidaysrequest = $holidaysrequest;

        return $this;
    }

    public function getHoursrequest(): ?float
    {
        return $this->hoursrequest;
    }

    public function setHoursrequest(?float $hoursrequest): self
    {
        $this->hoursrequest = $hoursrequest;

        return $this;
    }

    public function getHourssupp(): ?float
    {
        return $this->hourssupp;
    }

    public function setHourssupp(?float $hourssupp): self
    {
        $this->hourssupp = $hourssupp;

        return $this;
    }


    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(?bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getMoney(): ?float
    {
        return $this->money;
    }

    public function setMoney(?float $money): self
    {
        $this->money = $money;

        return $this;
    }
}
