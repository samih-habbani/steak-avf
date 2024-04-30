<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column]
    private ?bool $isAccepted = null;

    #[ORM\Column(nullable: true)]
    private ?int $likeCount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentTwo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentThree = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentFour = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $codeTwo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $codeThree = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $codeFour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function isIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): static
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(?int $likeCount): static
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getContentTwo(): ?string
    {
        return $this->contentTwo;
    }

    public function setContentTwo(?string $contentTwo): static
    {
        $this->contentTwo = $contentTwo;

        return $this;
    }

    public function getContentThree(): ?string
    {
        return $this->contentThree;
    }

    public function setContentThree(?string $contentThree): static
    {
        $this->contentThree = $contentThree;

        return $this;
    }

    public function getContentFour(): ?string
    {
        return $this->contentFour;
    }

    public function setContentFour(?string $contentFour): static
    {
        $this->contentFour = $contentFour;

        return $this;
    }

    public function getCodeTwo(): ?string
    {
        return $this->codeTwo;
    }

    public function setCodeTwo(?string $codeTwo): static
    {
        $this->codeTwo = $codeTwo;

        return $this;
    }

    public function getCodeThree(): ?string
    {
        return $this->codeThree;
    }

    public function setCodeThree(?string $codeThree): static
    {
        $this->codeThree = $codeThree;

        return $this;
    }

    public function getCodeFour(): ?string
    {
        return $this->codeFour;
    }

    public function setCodeFour(?string $codeFour): static
    {
        $this->codeFour = $codeFour;

        return $this;
    }
}
