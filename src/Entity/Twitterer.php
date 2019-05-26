<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TwittererRepository")
 */
class Twitterer
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Twitterer", inversedBy="twitterers")
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Twitterer", mappedBy="followers")
     */
    private $twitterers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="twitterer")
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $posts;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->twitterers = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTwitterers(): Collection
    {
        return $this->twitterers;
    }

    public function addTwitterer(self $twitterer): self
    {
        if (!$this->twitterers->contains($twitterer)) {
            $this->twitterers[] = $twitterer;
            $twitterer->addFollower($this);
        }

        return $this;
    }

    public function removeTwitterer(self $twitterer): self
    {
        if ($this->twitterers->contains($twitterer)) {
            $this->twitterers->removeElement($twitterer);
            $twitterer->removeFollower($this);
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setTwitterer($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getTwitterer() === $this) {
                $post->setTwitterer(null);
            }
        }

        return $this;
    }
}
