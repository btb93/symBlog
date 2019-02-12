<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * return Article|toString()
 */
class Article
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="article", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getTitre() : ? string
    {
        return $this->titre;
    }

    public function getSlug() : ? string
    {
        return (new Slugify())->slugify($this->titre);
    }

    public function setTitre(string $titre) : self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu() : ? string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu) : self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage() : ? string
    {
        return $this->image;
    }

    public function setImage(string $image) : self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreateAt() : ? \DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt) : self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getCategory() : ? Category
    {
        return $this->category;
    }

    public function setCategory(? Category $category) : self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires() : Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire) : self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire) : self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre . " " . $this->contenu . "";
    }
}
