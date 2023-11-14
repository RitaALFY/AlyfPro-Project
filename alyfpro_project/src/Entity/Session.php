<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'denormalization_context' => [
                'groups' => 'session:post'
            ]
        ],
        'get' => [
            'normalization_context' => [
                'groups' => 'session:list'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'session:item'
            ],
        ],
        'put',
        'delete',
    ],
    paginationItemsPerPage: 10,
)]

#[ApiFilter(
    SearchFilter::class, properties: [
    'title' => 'partial',
    'reference' =>'exact',

],
)]

class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?float $duration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Unique(message: 'La référence doit être unique. Veuillez entrer une autre référence.')]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private ?Module $module = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Formation::class)]
    #[Groups(['session:item', 'session:list', 'session:post'])]
    private Collection $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setSession($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getSession() === $this) {
                $formation->setSession(null);
            }
        }

        return $this;
    }
}
