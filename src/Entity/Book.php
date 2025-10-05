<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Nome do livro é obrigatório!')]
    #[
        Assert\Length(
            min: 10,
            max: 100,
            minMessage: 'Nome contém menos de 10 caracteres!',
            maxMessage: 'Acima do limite de 100 caracteres!'
        )
    ]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull()]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Genre $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull()]
    #[
        Assert\Length(
            min: 10,
            max: 255,
            minMessage: 'Sinopse precisa conter ao menos 10 caracteres',
            maxMessage: 'Sinopse acima dos 255 caracteres máximos'
        )
    ]
    private ?string $sinopse = null;

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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getSinopse(): ?string
    {
        return $this->sinopse;
    }

    public function setSinopse(?string $sinopse): static
    {
        $this->sinopse = $sinopse;

        return $this;
    }
}
