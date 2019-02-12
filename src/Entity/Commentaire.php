<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 * return Commentaire|toString()
 */
class Commentaire
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
    private $auteur;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getAuteur() : ? string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur) : self
    {
        $this->auteur = $auteur;

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

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getArticle() : ? Article
    {
        return $this->article;
    }

    public function setArticle(? Article $article) : self
    {
        $this->article = $article;

        return $this;
    }

    public function __toString()
    {
        return $this->auteur . "" . $this->contenu . "";
    }


}
