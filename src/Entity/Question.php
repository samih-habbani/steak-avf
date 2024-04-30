<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $viewCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $likeCount = null;

      #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class)]
    private Collection $answers;

    #[ORM\Column(nullable: true)]
    private ?bool $isClosed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closedDate = null;

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

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): static
    {
        $this->viewCount = $viewCount;

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


    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }
    
    

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function isIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(?bool $isClosed): static
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    public function getClosedDate(): ?\DateTimeInterface
    {
        return $this->closedDate;
    }

    public function setClosedDate(?\DateTimeInterface $closedDate): static
    {
        $this->closedDate = $closedDate;

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
