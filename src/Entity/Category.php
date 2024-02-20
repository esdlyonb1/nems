<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 3,minMessage: "hé coco, minimum 3 caractères s'il te plait",
        max: 50, maxMessage: "ola ca c'est un peu trop long, déso"
    )]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Nem::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $nems;

    public function __construct()
    {
        $this->nems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Nem>
     */
    public function getNems(): Collection
    {
        return $this->nems;
    }

    public function addNem(Nem $nem): static
    {
        if (!$this->nems->contains($nem)) {
            $this->nems->add($nem);
            $nem->setCategory($this);
        }

        return $this;
    }

    public function removeNem(Nem $nem): static
    {
        if ($this->nems->removeElement($nem)) {
            // set the owning side to null (unless already changed)
            if ($nem->getCategory() === $this) {
                $nem->setCategory(null);
            }
        }

        return $this;
    }
}
