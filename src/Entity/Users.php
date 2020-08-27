<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\UserData;


/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsVerified = false;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="editor", orphanRemoval=true)
     */
    private $demandes;

    /**
     * @ORM\OneToMany(targetEntity=Topics::class, mappedBy="author", orphanRemoval=true)
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="author", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToOne(targetEntity=UserData::class, mappedBy="users", cascade={"persist", "remove"})
     */
    private $userData;

    /**
     * @ORM\OneToMany(targetEntity=DemandeCSE::class, mappedBy="user")
     */
    private $demandeCSEs;

    /**
     * @ORM\OneToMany(targetEntity=DemandeComptable::class, mappedBy="user")
     */
    private $demandeComptables;



    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->demandeCSEs = new ArrayCollection();
        $this->demandeComptables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsVerified(): ?bool
    {
        return $this->IsVerified;
    }

    public function setIsVerified(bool $IsVerified): self
    {
        $this->IsVerified = $IsVerified;

        return $this;
    }


    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setEditor($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getEditor() === $this) {
                $demande->setEditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Topics[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topics $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setAuthor($this);
        }

        return $this;
    }

    public function removeTopic(Topics $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getAuthor() === $this) {
                $topic->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAuthor($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuthor() === $this) {
                $commentaire->setAuthor(null);
            }
        }

        return $this;
    }

    public function getUserData(): ?UserData
    {
        return $this->userData;
    }

    public function setUserData(UserData $userData): self
    {
        $this->userData = $userData;

        // set the owning side of the relation if necessary
        if ($userData->getUsers() !== $this) {
            $userData->setUsers($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    /**
     * @return Collection|DemandeCSE[]
     */
    public function getDemandeCSEs(): Collection
    {
        return $this->demandeCSEs;
    }

    public function addDemandeCSE(DemandeCSE $demandeCSE): self
    {
        if (!$this->demandeCSEs->contains($demandeCSE)) {
            $this->demandeCSEs[] = $demandeCSE;
            $demandeCSE->setUser($this);
        }

        return $this;
    }

    public function removeDemandeCSE(DemandeCSE $demandeCSE): self
    {
        if ($this->demandeCSEs->contains($demandeCSE)) {
            $this->demandeCSEs->removeElement($demandeCSE);
            // set the owning side to null (unless already changed)
            if ($demandeCSE->getUser() === $this) {
                $demandeCSE->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DemandeComptable[]
     */
    public function getDemandeComptables(): Collection
    {
        return $this->demandeComptables;
    }

    public function addDemandeComptable(DemandeComptable $demandeComptable): self
    {
        if (!$this->demandeComptables->contains($demandeComptable)) {
            $this->demandeComptables[] = $demandeComptable;
            $demandeComptable->setUser($this);
        }

        return $this;
    }

    public function removeDemandeComptable(DemandeComptable $demandeComptable): self
    {
        if ($this->demandeComptables->contains($demandeComptable)) {
            $this->demandeComptables->removeElement($demandeComptable);
            // set the owning side to null (unless already changed)
            if ($demandeComptable->getUser() === $this) {
                $demandeComptable->setUser(null);
            }
        }

        return $this;
    }
}
