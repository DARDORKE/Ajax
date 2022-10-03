<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: FavPost::class)]
    private Collection $favPosts;

    public function __construct()
    {
        $this->favPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, FavPost>
     */
    public function getFavPosts(): Collection
    {
        return $this->favPosts;
    }

    public function addFavPost(FavPost $favPost): self
    {
        if (!$this->favPosts->contains($favPost)) {
            $this->favPosts->add($favPost);
            $favPost->setPost($this);
        }

        return $this;
    }

    public function removeFavPost(FavPost $favPost): self
    {
        if ($this->favPosts->removeElement($favPost)) {
            // set the owning side to null (unless already changed)
            if ($favPost->getPost() === $this) {
                $favPost->setPost(null);
            }
        }

        return $this;
    }

    public function isFavByUser(User $user): bool {
        foreach ($this->favPosts as $favPost) {
            if($favPost->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
