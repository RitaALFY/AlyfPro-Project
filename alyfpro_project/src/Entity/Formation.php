<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\FormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'denormalization_context' => [
                'groups' => 'formation:post'
            ]
        ],
        'get' => [
            'normalization_context' => [
                'groups' => 'formation:list'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'formation:item'
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

class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?float $duration = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Unique(message: 'La référence doit être unique. Veuillez entrer une autre référence.')]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?string $modality = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[Groups(['formation:item', 'formation:list', 'formation:post'])]
    private ?Session $session = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): static
    {
        $this->duration = $duration;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
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

    public function getModality(): ?string
    {
        return $this->modality;
    }

    public function setModality(?string $modality): static
    {
        $this->modality = $modality;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }
}
