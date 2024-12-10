<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 180, unique: true)]
  private ?string $email = null;

  #[ORM\Column(type: 'json')]
  private array $roles = [];

  #[ORM\Column(type: 'string')]
  private ?string $password = null;

  #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Contribution::class, orphanRemoval: true)]
  private Collection $contributions;

  #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Projet::class)]
  private Collection $projets;

  public function __construct()
  {
    $this->contributions = new ArrayCollection();
    $this->projets = new ArrayCollection();
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

  public function getRoles(): array
  {
    // Garantir que chaque utilisateur ait au moins le rôle ROLE_USER
    $roles = $this->roles;
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

    return $this;
  }
  public function getFormattedRoles(): string
{
    return implode(', ', $this->roles);
}


  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getUserIdentifier(): string
  {
    return $this->email;
  }

  public function eraseCredentials(): void
  {
    // Si des données sensibles sont temporaires, nettoyez-les ici
  }

  /**
   * @return Collection<int, Contribution>
   */
  public function getContributions(): Collection
  {
    return $this->contributions;
  }

  public function addContribution(Contribution $contribution): self
  {
    if (!$this->contributions->contains($contribution)) {
      $this->contributions->add($contribution);
      $contribution->setUtilisateur($this);
    }

    return $this;
  }

  public function removeContribution(Contribution $contribution): self
  {
    if ($this->contributions->removeElement($contribution)) {
      // Unset the owning side if the relation is removed
      if ($contribution->getUtilisateur() === $this) {
        $contribution->setUtilisateur(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, Projet>
   */
  public function getProjets(): Collection
  {
    return $this->projets;
  }

  public function addProjet(Projet $projet): self
  {
    if (!$this->projets->contains($projet)) {
      $this->projets->add($projet);
      $projet->setCreateur($this);
    }

    return $this;
  }

  public function removeProjet(Projet $projet): self
  {
    if ($this->projets->removeElement($projet)) {
      // Unset the owning side if the relation is removed
      if ($projet->getCreateur() === $this) {
        $projet->setCreateur(null);
      }
    }

    return $this;
  }
}
