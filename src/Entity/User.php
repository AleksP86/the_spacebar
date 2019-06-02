<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=180, unique=true)
    * @Groups("main")
    */
    private $email;

    /**
    * @ORM\Column(type="json")
    */
    private $roles=[];

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdDate;

    /**
    * @ORM\Column(type="string", length=255)
    * @Groups("main")
    */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("main")
     */
    private $twitterUsername;

    private $avatarUrl;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApiToken", mappedBy="user", orphanRemoval=true)
     */
    private $orphanRemoval;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author")
     */
    private $articles;

    public function __construct()
    {
        $this->orphanRemoval = new ArrayCollection();
        $this->articles = new ArrayCollection();
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
        $this->email=$email;
        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function getRoles():array
    {
        $roles=$this->roles;
        $roles[]='ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles=$roles;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName= $firstName;
        return $this;
    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }

    public function getTwitterUsername(): ?string
    {
        return $this->twitterUsername;
    }

    public function setTwitterUsername(?string $twitterUsername): self
    {
        $this->twitterUsername = $twitterUsername;

        return $this;
    }

    public function getAvatarUrl(string $size = null): string
    {
        $url = 'https://robohash.org/'.$this->getEmail();

        if($size)
            $url .=sprintf('?size=%dx%d', $size, $size);

        return $url;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getOrphanRemoval(): Collection
    {
        return $this->orphanRemoval;
    }

    public function addOrphanRemoval(ApiToken $orphanRemoval): self
    {
        if (!$this->orphanRemoval->contains($orphanRemoval)) {
            $this->orphanRemoval[] = $orphanRemoval;
            $orphanRemoval->setUser($this);
        }

        return $this;
    }

    public function removeOrphanRemoval(ApiToken $orphanRemoval): self
    {
        if ($this->orphanRemoval->contains($orphanRemoval)) {
            $this->orphanRemoval->removeElement($orphanRemoval);
            // set the owning side to null (unless already changed)
            if ($orphanRemoval->getUser() === $this) {
                $orphanRemoval->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstName();
    }
}
